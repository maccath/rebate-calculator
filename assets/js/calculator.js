$(function () {
    // Topup fee type show/hide
    var $topupFeeType = $('[name="topup_fee"]');
    var $feeAmountInput = $('#fee_amount');
    var $feeAmountControl = $('#fee_amount_control');

    var $poundSign = $feeAmountControl.find('.input-group-addon:first');
    var $percentageSign = $feeAmountControl.find('.input-group-addon:last');

    var showHideTopupFeeTypes = function () {
        var feeType = $topupFeeType.filter(':checked').val();

        $poundSign.hide();
        $percentageSign.hide();

        if (feeType == 'none') {
            $feeAmountControl.hide();
            $feeAmountInput.prop('disabled', true);
        } else {
            $feeAmountControl.show();
            $feeAmountInput.prop('disabled', false);

            if (feeType == 'percentage') {
                $percentageSign.show();
            } else if (feeType == 'flat') {
                $poundSign.show();
            }
        }
    };

    showHideTopupFeeTypes();
    $topupFeeType.on('change', function () {
        showHideTopupFeeTypes();
    });
});