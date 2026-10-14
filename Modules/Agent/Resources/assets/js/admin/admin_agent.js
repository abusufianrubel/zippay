"use strict";

let hasPhoneError = false;
let hasEmailError = false;

function enableDisableButton() {
    let $submitButton = $('form button[type="submit"]');
    $submitButton.prop('disabled', hasPhoneError || hasEmailError);
}

function disableSubmitBtn(btn_id, btn_text_id, submitButtonText) {
    $(btn_id).attr("disabled", true);
    $(".fa-spin").removeClass('d-none');
    $(btn_text_id).text(submitButtonText);
}

function validateEmail(email) {
    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

function emptyEmail() {
    $('#email_error').remove();
}

$(function() {
    $(".select2").select2({});
});

var $pwd1 = $('#password');
var $pwd2 = $('#password_confirmation');

function confirmPwd() {
    if ($pwd1.val() != $pwd2.val()) {
        $('.password_confirmation').text(passErrorMgs)
    } else {
        $('.password_confirmation').text('');
    }
}

$pwd1.on('change', confirmPwd);
$pwd2.on('keyup', confirmPwd);

function restrictNumberToPrefdecimalOnInput(e) {
    var type = $('select#currency_id').find(':selected').data('type')
    restrictNumberToPrefdecimal(e, type);
}

if ($('.content').find('#agent-create').length) {
    function formattedPhone() {
        if ($('#phone').val()) {
            $("#formattedPhone").val($('#phone').intlTelInput("getNumber").replace(/-|\s/g, ""));
        }
    }
    //Invalid Number Validation - admin create
    $(document).ready(function() {
        $("#phone").intlTelInput({
            separateDialCode: true,
            nationalMode: true,
            preferredCountries: [countryShortCode],
            autoPlaceholder: "polite",
            placeholderNumberType: "MOBILE",
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : countryShortCode;
                    callback(countryCode);
                });
            },
            utilsScript: utilsScriptLoadingPath,
        });

        $("#phone").on("countrychange", function(e) {

            formattedPhone();

            $('#iso2').val($("#phone").intlTelInput("getSelectedCountryData").iso2);
            $('#dialCode').val($("#phone").intlTelInput("getSelectedCountryData").dialCode);

            if ($.trim($(this).val()) !== '') {

                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html(phnErrorMgs);
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#duplicate-phone-error').hide();
                } else {
                    $('#tel-error').html('');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "GET",
                        url: phoneCheckUrl,
                        dataType: "json",
                        cache: false,
                        data: {
                            'phone': $.trim($(this).val()),
                            'dial_code': $.trim($("#phone").intlTelInput("getSelectedCountryData").dialCode),
                        }
                    })
                    .done(function(response) {
                        if (response.status) {
                            $('#tel-error').html('');
                            $('#duplicate-phone-error').show();

                            $('#duplicate-phone-error').addClass('error').html(response.fail);
                            hasPhoneError = true;
                            enableDisableButton();
                        } else {
                            $('#tel-error').show();
                            $('#duplicate-phone-error').html('');

                            hasPhoneError = false;
                            enableDisableButton();
                        }
                    });
                }
            } else {
                $('#tel-error').html('');
                $('#duplicate-phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });
        
        $("input[name=phone]").on('blur', function(e) {

            formattedPhone();

            if ($.trim($(this).val()) !== '') {

                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html(phnErrorMgs);
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#duplicate-phone-error').hide();
                } else {
                    var phone = $(this).val().replace(/-|\s/g,"");
                    var phone = $(this).val().replace(/^0+/,"");

                    var pluginCarrierCode = $.trim($("#phone").intlTelInput("getSelectedCountryData").dialCode);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: "GET",
                        url: phoneCheckUrl,
                        dataType: "json",
                        data: {
                            'phone': phone,
                            'dial_code': pluginCarrierCode,
                        }
                    }).done(function(response) {
                        if (response.status) {
                            if (phone.length == 0) {
                                $('#duplicate-phone-error').html('');
                            } else {
                                $('#duplicate-phone-error').addClass('error').html(response.fail);
                                hasPhoneError = true;
                                enableDisableButton();
                            }
                        } else {
                            $('#duplicate-phone-error').html('');
                            hasPhoneError = false;
                            enableDisableButton();
                        }
                    });
                    $('#tel-error').html('');
                    $('#duplicate-phone-error').show();
                    hasPhoneError = false;
                    enableDisableButton();
                }
            } else {
                $('#tel-error').html('');
                $('#duplicate-phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });

        $("#email").on('blur', function(e) {
            var email = $('#email').val();
            emptyEmail();

            if (!validateEmail(email)) {
                $('#email').parent('div').append('<span id="email_error" class="error">'+ validEmailErrorMgs +'</span>');
                hasEmailError = false;
                enableDisableButton();
                return false;
            }
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: emailCheckUrl,
                dataType: "json",
                data: {
                    'email': email,
                }
            }).done(function(response) {
                if (response.status) {
                    $('#email').parent('div').append('<span id="email_error" class="error">' + response.fail + '</span>');
                    hasEmailError = true;
                    enableDisableButton();
                } else {
                    emptyEmail();
                    hasEmailError = false;
                    enableDisableButton();
                }
            });
        });
    });

    $(document).on("submit", "#agent-create-form", function () {
        disableSubmitBtn("#agent-create-btn", "#agent-create-btn-text", submitButtonText);
    });

    $(window).on('load', function() {
        $('#iso2').val($("#phone").intlTelInput("getSelectedCountryData").iso2);
        $('#dialCode').val($("#phone").intlTelInput("getSelectedCountryData").dialCode);
    });
}

if ($('.content-wrapper').find('#agent-edit').length) {
    $(function () {
        $(".select2").select2({});
    });
    
    function enableDisableButton()
    {
        if (!hasPhoneError && !hasEmailError) {
            $('form').find("button[type='submit']").prop('disabled',false);
        } else {
            $('form').find("button[type='submit']").prop('disabled',true);
        }
    }

    $("#phone").intlTelInput({
        separateDialCode: true,
        nationalMode: true,
        preferredCountries: [countryShortCode],
        autoPlaceholder: "polite",
        placeholderNumberType: "MOBILE",
        formatOnDisplay: false,
        utilsScript: utilsScriptLoadingPath
    })
    
    if (formattedPhoneNumber !== null && dialCode !== null && iso2 !== null) {
        $("#phone").intlTelInput("setNumber", formattedPhoneNumber);
        $('#iso2').val(iso2);
        $('#dialCode').val(dialCode);
    }

    function updatePhoneInfo()
    {
        let promiseObj = new Promise(function(resolve, reject)
        {
            $('#iso2').val($('#phone').intlTelInput('getSelectedCountryData').iso2);
            $('#dialCode').val($('#phone').intlTelInput('getSelectedCountryData').dialCode);

            if ($('#phone').val != '') {
                $("#formattedPhone").val($('#phone').intlTelInput("getNumber").replace(/-|\s/g,""));
            }
            resolve();
        });  
        return promiseObj;  
    }

    function checkDuplicatePhoneNumber()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            url: phoneCheckUrl,
            dataType: 'json',
            cache: false,
            data: {
                'phone': $.trim($('#phone').val()),
                'dial_code': $.trim($('#phone').intlTelInput('getSelectedCountryData').dialCode),
                'agent_id': $('#id').val(),
            }
        })
        .done(function(response)
        {
            if (response.status) {
                $('#duplicate-phone-error').show().addClass('error').html(response.fail);
                hasPhoneError = true;
                enableDisableButton();
            } else {
                $('#duplicate-phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });
    }

    function validateInternaltionalPhoneNumber()
    {
        let promiseObj = new Promise(function(resolve, reject)
        {
            let resolveStatus = false;
            if ($.trim($('#phone').val()) !== '') {
                if (!$('#phone').intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($('#phone').val()))) {
                    $('#duplicate-phone-error').html('');
                    $('#tel-error').addClass('error').html(phnErrorMgs);
                    hasPhoneError = true;
                    enableDisableButton();
                } else {
                    resolveStatus = true;
                    $('#tel-error').html('');
                    hasPhoneError = false;
                    enableDisableButton();
                }
            } else {
                $('#tel-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
            resolve(resolveStatus);
        });  
        return promiseObj;  
    }

    function phoneValidityCheck()
    {
        updatePhoneInfo()
        .then(() => 
        {
            validateInternaltionalPhoneNumber()
            .then((status) => 
            {
                if (status) {
                    checkDuplicatePhoneNumber();
                }
            });
        });
    }

    $("#phone").on("countrychange", function()
    {
        phoneValidityCheck();
    });

    $("#phone").on('blur', function()
    {
        phoneValidityCheck();
    });

    // Validate email via Ajax
    $(document).ready(function()
    {
        $("#email").on('input', function(e) {
            var email = $(this).val();
            var id = $('#id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: emailCheckUrl,
                dataType: "json",
                data: {
                    'email': email,
                    'agent_id': id,
                }
            })
            .done(function(response)
            {
                emptyEmail(email);
                if (response.status) {
                    if (validateEmail(email)) {
                        $('#emailError').text(response.fail).css('color', 'red');
                        $('#email-ok').html('');
                        hasEmailError = true;
                        enableDisableButton();
                    } else {
                        $('#emailError').text('').css('color', '');
                    }
                } else {
                    hasEmailError = false;
                    enableDisableButton();
                    if (validateEmail(email)) {
                        $('#emailError').text('').css('color', '');
                    } else {
                        $('#email-ok').html('');
                    }
                }
            });
        });
    });

    /**
     * [validateEmail description]
     * @param  {null} email [regular expression for email pattern]
     * @return {null}
     */
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    /**
     * [checks whether email value is empty or not]
     * @return {void}
     */
    function emptyEmail(email) {
        if( email.length === 0 ) {
            $('#emailError').text('').css('color', '');
            $('#email-ok').html('');
        }
    }

    $(document).on("submit", "#agentEditForm", function () {
        disableSubmitBtn("#agentUpdateSubmitBtn", "#agentUpdateSubmitBtnText", submitButtonText);
    });
}

if ($('.content').find('#deposit').length) {
    $('#agentDepositForm').validate({
        rules: {
            amount: {
                required: true,
            },
        }
    });

    function determineDecimalPoint() {

        var currencyType = $('select#currency_id').find(':selected').data('type')

        if (currencyType == 'fiat') {
            $('.pFees, .fFees, .total_fees').text(FIATDP);
            $("#amount").attr('placeholder', FIATDP);
        }
    }

    $(window).on('load', function (e) {
        determineDecimalPoint();
        checkAmountLimitAndFeesLimit();
    });

    $(document).on('input', '.amount', function (e) {
        checkAmountLimitAndFeesLimit();
    });

    $(document).on('change', '.wallet', function (e) {
        determineDecimalPoint();
        checkAmountLimitAndFeesLimit();
    });

    function checkAmountLimitAndFeesLimit() {
        var token = $('input[name = _token]').val();
        var amount = $('#amount').val();
        var currency_id = $('#currency_id').val();
        var payment_method_id = $('#payment_method').val();

        $.ajax({
            method: "POST",
            url: ajaxUrl,
            dataType: "json",
            data: {
                "_token": token,
                'amount': amount,
                'currency_id': currency_id,
                'payment_method_id': payment_method_id,
                'agent_id': agentId,
                'transaction_type_id': transactionTypeId
            }
        }).done(function (response) {
            if (response.success.status == 200) {
                $("#percentage_fee").val(response.success.feesPercentage);
                $("#fixed_fee").val(response.success.feesFixed);
                $(".percentage_fees").html(response.success.feesPercentage);
                $(".fixed_fees").html(response.success.feesFixed);
                $(".total_fees").val(response.success.totalFees);
                $('.total_fees').html(response.success.totalFeesHtml);
                $('.pFees').html(response.success.pFeesHtml);
                $('.fFees').html(response.success.fFeesHtml);

                $('.amountLimit').text('');
                $("#depositCreateSubmitBtn").attr("disabled", false);
                return true;
            } else {
                if (amount == '') {
                    $('.amountLimit').text('');
                } else {
                    $('.amountLimit').text(response.success.message);
                    $("#depositCreateSubmitBtn").attr("disabled", true);
                    return false;
                }
            }
        });
    }

    $(document).on("submit", "#agentDepositForm", function () {
        disableSubmitBtn("#depositCreateSubmitBtn", "#depositCreateSubmitBtnText", submitButtonText);
    });
}

if ($('.content').find('#depositConfirm').length) {
    $(document).on("submit", "#agentDepositConfirmForm", function () {
        disableSubmitBtn("#agentDepositConfirmSubmitBtn", "#agentDepositConfirmSubmitBtnText", submitButtonText);
    });
}
if ($('.content').find('#revenue').length) {

    var sDate;
    var eDate;

    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    },
        function (start, end) {
            var sessionDate = dateFormateType;;
            var sessionDateFinal = sessionDate.toUpperCase();

            sDate = moment(start, 'MMMM D, YYYY').format(sessionDateFinal);
            $('#startfrom').val(sDate);

            eDate = moment(end, 'MMMM D, YYYY').format(sessionDateFinal);
            $('#endto').val(eDate);

            $('#daterange-btn span').html('&nbsp;' + sDate + ' - ' + eDate + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        }
    )

    $(document).ready(function () {
        $("#daterange-btn").mouseover(function () {
            $(this).css('background-color', 'white');
            $(this).css('border-color', 'grey !important');
        });

        var startDate = formDate;
        var endDate = toDate;
        if (startDate == '') {
            $('#daterange-btn span').html('<i class="fa fa-calendar"></i>'+ ' ' + pickDateRange + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        } else {
            $('#daterange-btn span').html(startDate + ' - ' + endDate + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        }
    });

    // csv
    $(document).ready(function () {
        $('#csv').on('click', function (event) {
            event.preventDefault();
            var startfrom = $('#startfrom').val();
            var endto = $('#endto').val();
            var currency = $('#currency').val();
            var type = $('#type').val();
            var user_id = $('#user_id').val();
            window.location = SITE_URL + "/admin/agents/revenues/csv?startfrom=" + startfrom +
                "&endto=" + endto +
                "&currency=" + currency +
                "&type=" + type +
                "&user_id=" + user_id;
        });
    });

    // pdf
    $(document).ready(function () {
        $('#pdf').on('click', function (event) {
            event.preventDefault();
            var startfrom = $('#startfrom').val();
            var endto = $('#endto').val();
            var currency = $('#currency').val();
            var type = $('#type').val();
            var user_id = $('#user_id').val();
            window.location = SITE_URL + "/admin/agents/revenues/pdf?startfrom=" + startfrom +
                "&endto=" + endto +
                "&currency=" + currency +
                "&type=" + type +
                "&user_id=" + user_id;
        });
    });

    $("#user_input").on('keyup keypress', function (e) {
        if (e.type == "keyup" || e.type == "keypress") {
            let user_input = $('form').find("input[type='text']").val();
            if (user_input.length === 0) {
                $('#user_id').val('');
                $('#error-user').html('');
                $('form').find("button[type='submit']").prop('disabled', false);
            }
        }
    });

    $('#user_input').autocomplete({
        source: function (req, res) {
            if (req.term.length > 0) {
                $.ajax({
                    url: ajaxUrl,
                    dataType: 'json',
                    type: 'get',
                    data: {
                        search: req.term
                    },
                    success: function (response) {
                        $('form').find("button[type='submit']").prop('disabled', true);
                        if (response.status == 'success') {
                            res($.map(response.data, function (item) {
                                return {
                                    id: item.agent_id,
                                    first_name: item.first_name,
                                    last_name: item.last_name,
                                    value: item.first_name + ' ' + item.last_name
                                }
                            }));
                        } else if (response.status == 'fail') {
                            $('#error-user').addClass('text-danger').html(userDoesntExist);
                        }
                    }
                })
            } else {
                $('#user_id').val('');
            }
        },
        select: function (event, ui) {
            var e = ui.item;
            $('#error-user').html('');
            $('#user_id').val(e.id);
            $('form').find("button[type='submit']").prop('disabled', false);
        },
        minLength: 0,
        autoFocus: true
    });
}