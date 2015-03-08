$(function () {
    // Topup fee type show/hide
    var $topupFeeType = $('[name="topup_fee"]');
    var $topupFlatFee = $('#flat_fee_amount_control');
    var $topupPercentageFee = $('#percentage_fee_amount_control');

    var showHideTopupFeeTypes = function() {
        switch ($topupFeeType.filter(':checked').val()) {
            case 'percentage':
                $topupFlatFee.hide();
                $topupPercentageFee.show();
                break;

            case 'flat':
                $topupFlatFee.show();
                $topupPercentageFee.hide();
                break;

            default:
                $topupFlatFee.hide();
                $topupPercentageFee.hide();
                break;
        }
    };

    showHideTopupFeeTypes();
    $topupFeeType.on('change', function () {
        showHideTopupFeeTypes();
    });
});