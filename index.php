<?php

use RebateCalculator\Card;
use RebateCalculator\FlatFee;
use RebateCalculator\Item;
use RebateCalculator\PercentageFee;
use RebateCalculator\PercentageRebate;
use RebateCalculator\Store;
use RebateCalculator\TopUpCalculator;
use RebateCalculator\TopUpFacility;

include('vendor/autoload.php');

// Set up configuration options
$config = include('config/config.php');
if (file_exists('config/local.config.php')) {
    $config = array_merge($config, include('config/local.config.php'));
}

// Load Twig templating engine
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, $config['twig']);

$data = [
    'application' => $config['application'],
];


// Display the form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo $twig->render('index.html', array_merge(['title' => 'Calculator'], $data));
    exit;
}


$minimumTopUp = round(floatval($_POST['minimum_topup'] ?? 0), 2);
$cardBalance = round(floatval($_POST['current_balance'] ?? 0), 2);
$storeName = strip_tags($_POST['store_name'] ?? 'Unnamed');
$rebateAmount = round(floatval($_POST['percentage_rebate_amount'] ?? 0), 2);
$itemCost = round(floatval($_POST['item_cost'] ?? 0), 2);
$feeType = in_array($_POST['topup_fee'] ?? '', ['percentage', 'flat']) ? $_POST['topup_fee'] : 'flat';
$feeAmount = round(floatval($_POST['fee_amount'] ?? 0), 2);

try {
    $fee = $feeType == 'percentage' ? new PercentageFee($feeAmount) : new FlatFee($feeAmount);

    $topUpFacility = new TopUpFacility($fee, $minimumTopUp);

    $card = new Card($topUpFacility, $cardBalance);

    $rebate = new PercentageRebate($rebateAmount);

    $store = new Store($storeName, $rebate);

    $item = new Item($itemCost);

    $topUpCalculator = new TopUpCalculator($card, $item);

    $topUpAmount = $topUpCalculator->calculateTopUpRequired();

    $topUpCost = $topUpFacility->getTopUpCost($topUpAmount);
    $card->topUp($topUpAmount);

    $rebateValue = $store->calculateRebateValue($item);

    $card->payFor($item);
    $card->receiveRebate($item, $store);

    $data = array_merge($data, [
        'item' => $item,
        'store' => $store,
        'card' => $card,
        'fee' => $fee,
        'fee_type' => $feeType,
        'result' => [
            'topUpCost' => $topUpCost,
            'topUpRequired' => $topUpAmount,
            'rebate' => $rebateValue,
            'previousBalance' => $cardBalance,
            'remainingBalance' => $card->getBalance(),
            'saving' => $rebateValue - $topUpCost,
        ],
    ]);
} catch (Exception $e) {
    $data['error'] = $e->getMessage();
}

echo $twig->render('result.html', array_merge(['title' => 'Results'], $data));