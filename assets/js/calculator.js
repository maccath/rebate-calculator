$(function () {
    // Topup fee type show/hide
    var $topupFeeType = $('[name="topup_fee"]');
    var $topupFeeAmount = $('#fee_amount_control');
    var $topupFeeAmountAddons = $topupFeeAmount.find('.input-group-addon');

    var showHideTopupFeeTypes = function () {
        switch ($topupFeeType.filter(':checked').val()) {
            case 'percentage':
                $topupFeeAmount.show();
                $topupFeeAmountAddons.hide();
                $topupFeeAmountAddons.filter(':last').show();
                break;

            case 'flat':
                $topupFeeAmount.show();
                $topupFeeAmountAddons.hide();
                $topupFeeAmountAddons.filter(':first').show();
                break;

            default:
                $topupFeeAmount.hide();
                break;
        }
    };

    showHideTopupFeeTypes();
    $topupFeeType.on('change', function () {
        showHideTopupFeeTypes();
    });
});