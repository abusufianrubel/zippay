// Enable strict mode
"use strict";

function restrictNumberToPrefdecimalOnInput(e) {
    restrictNumberToPrefdecimal(e, type);
}

function formatNumberToPrefDecimal(num = 0) {
    num = ((Math.abs(num)).toFixed(decimal_format))
    return num;
}

if ($('.content').find('#feesLimits').length) {
    $(".has_transaction").on("click", function () {
        let currencyId = $(this).data('currency_id');
        let transactionCheckbox = $('#has_transaction_' + currencyId);
        let minLimit = $('#min_limit_' + currencyId);
        let maxLimit = $('#max_limit_' + currencyId);
        let chargePercentage = $('#charge_percentage_' + currencyId);
        let chargeFixed = $('#charge_fixed_' + currencyId);

        if (transactionCheckbox.prop('checked')) {
            transactionCheckbox.val('Yes');
            [minLimit, maxLimit, chargePercentage, chargeFixed].forEach(function (element) {
                element.prop("readonly", false);
            });
        } else {
            transactionCheckbox.val('');
            [minLimit, maxLimit, chargePercentage, chargeFixed].forEach(function (element) {
                element.prop("readonly", true);
            });
        }
    });

    $('#agentFeesLimitForm').on('submit', function() {
        $('#agentFeesLimitsUpdate').attr('disabled', true);
        $('#agentFeesLimitsCancel').attr('disabled',true);
        $('.fa-spin').removeClass('d-none');
        $('#agentFeesLimitsUpdateText').text(updatingText);
    });
}
