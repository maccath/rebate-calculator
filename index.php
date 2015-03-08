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

if ($_POST) {
    // Fetch user input
    $minimumTopup = $_POST['minimum_topup']
        ? round(floatval($_POST['minimum_topup']), 2) : 0;
    $cardBalance = $_POST['current_balance']
        ? round(floatval($_POST['current_balance']), 2) : 0;
    $storeName = $_POST['store_name'] ? strip_tags($_POST['store_name'])
        : 'Unnamed';
    $rebateAmount = $_POST['percentage_rebate_amount']
        ? round(floatval($_POST['percentage_rebate_amount']), 2) : 0;
    $itemCost = $_POST['item_cost'] ? round(floatval($_POST['item_cost']), 2)
        : 0;

    // Construct fee
    if ($_POST['topup_fee'] == 'flat') {
        $feeAmount = round(floatval($_POST['flat_fee_amount']), 2);
        $fee = new \RebateCalculator\FlatFee($feeAmount);
    } else if ($_POST['topup_fee'] == 'percentage') {
        $feeAmount = round(floatval($_POST['percentage_fee_amount']), 2);
        $fee = new \RebateCalculator\PercentageFee($feeAmount);
    } else {
        $fee = new \RebateCalculator\FlatFee(0);
    }

    // Construct topup facility
    $topup = new \RebateCalculator\Topup($fee, $minimumTopup);

    // Construct card
    $card = new RebateCalculator\Card($topup, $cardBalance);

    // Construct rebate
    $rebate = new \RebateCalculator\PercentageRebate($rebateAmount);

    // Construct store
    $store = new \RebateCalculator\Store($storeName, $rebate);

    // Construct item
    $item = new \RebateCalculator\Item($itemCost);

    // Calculate savings
    $calculator = new \RebateCalculator\SavingsCalculator($card, $store, $item);

    $result['overall_cost'] = $calculator->calculateCost();
    $result['topupRequired'] = $calculator->calculateTopupRequired();
    $result['rebate'] = $calculator->calculateRebateAmount();
    $result['remainingBalance'] = $calculator->calculateRemainingBalance();

    echo json_encode($result);

} else {

    echo $twig->render('index.html', array_merge(array('title' => 'Calculator'), $data));

}

