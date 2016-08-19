<?php

include('vendor/autoload.php');

// Set up configuration options
$config = array();
include('config/config.php');
if (file_exists('config/local.config.php')) {
    include('config/local.config.php');
}

// Load Twig templating engine
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, $config['twig']);

$data = array(
    'application' => $config['application'],
);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;

if ($action == 'calculate') {
    try {
        if (!($_POST)) {
            throw new \Exception(sprintf(
                'No direct access.'
            ));
        };

        // Fetch user input
        $minimumTopup = isset($_POST['minimum_topup'])
            ? round(floatval($_POST['minimum_topup']), 2)
            : 0;

        $cardBalance = isset($_POST['current_balance'])
            ? round(floatval($_POST['current_balance']), 2)
            : 0;

        $storeName = isset($_POST['store_name'])
            ? strip_tags($_POST['store_name'])
            : 'Unnamed';

        $rebateAmount = isset($_POST['percentage_rebate_amount'])
            ? round(floatval($_POST['percentage_rebate_amount']), 2)
            : 0;

        $itemCost = isset($_POST['item_cost'])
            ? round(floatval($_POST['item_cost']), 2)
            : 0;

        // Construct fee
        $feeAmount =  isset($_POST['fee_amount'])
            ? round(floatval($_POST['fee_amount']), 2)
            : 0;


        if (isset($_POST['topup_fee']) && $_POST['topup_fee'] == 'percentage') {
            $fee = new \RebateCalculator\PercentageFee($feeAmount);
        } else {
            $fee = new \RebateCalculator\FlatFee($feeAmount);
        }

        // Construct topup facility
        $topup = new \RebateCalculator\TopUpFacility($fee, $minimumTopup);

        // Construct card
        $card = new RebateCalculator\Card($topup, $cardBalance);

        // Construct rebate
        $rebate = new \RebateCalculator\PercentageRebate($rebateAmount);

        // Construct store
        $store = new \RebateCalculator\Store($storeName, $rebate);

        // Construct item
        $item = new \RebateCalculator\Item($itemCost);

        $card->topUp($item);
        $card->payFor($item);
        $card->receiveRebate($item, $store);

        $topupCost = $card->getTopUpFacility()->calculateTopupCost();
        $rebateValue = $store->calculateRebateAmount($item);
        
        $data = array_merge($data, array(
            'item' => $item,
            'store' => $store,
            'card' => $card,
            'result' => array(
                'topupCost' => $topupCost,
                'topupRequired' => $card->getTopUpFacility()->getAmount(),
                'rebate' => $rebateValue,
                'remainingBalance' => $card->getBalance(),
                'saving' => $rebateValue - $topupCost,
            ),
        ));
    } catch (\Exception $e) {
        $data['error'] = $e->getMessage();
    }

    echo $twig->render('result.html',
        array_merge(array('title' => 'Results'), $data));

} else {

    echo $twig->render('index.html',
        array_merge(array('title' => 'Calculator'), $data));

}
