"use strict";

function changeProfile() {
    $('#upload').trigger('click');
}

function restrictNumberToPrefdecimalOnInput(e) {
    let type = $('select#currency_id').find(':selected').data('type')
    restrictNumberToPrefdecimal(e, type);
}

if ($('.main-containt').find('#agentProfile').length) {
    //start - ajax image upload
    $('#upload').on('change', function () {
        if ($(this).val() != '') {
            upload(this);
        }
    });

    function upload(img) {
        let form_data = new FormData();
        form_data.append('file', img.files[0]);
        form_data.append('_token', csrfToken);
        $('#loading').css('display', 'block');
        $.ajax({
            url: profileImageUploadUrl,
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            success: function (data) {
                if (data.fail) {
                    $('#file-error').show().addClass('error').html(data.errors.file);
                } else {
                    $('#file-error').hide();
                    $('#file_name').val(data);
                    location.reload();
                }
                $('#loading').css('display', 'none');
            },
            error: function (xhr, status, error) {
            }
        });
    }

    function phoneValidityCheck() {
        updatePhoneInfo()
        .then(() => {
            validateInternaltionalPhoneNumber()
            .then((status) => {
                if (status) {
                    checkDuplicatePhoneNumber();
                }
            });
        });
    }

    $("#phone").on("countrychange", function () {
        phoneValidityCheck();
    });
    
    $("#phone").on('blur', function () {
        phoneValidityCheck();
    });

    $("#phone").on('input', function () {
        phoneValidityCheck();
    });

    $('#defaultCurrencyForm').on('submit', function () {
        $('#defaultCurrencySubmitBtn').attr("disabled", true);
    	$(".spinner").removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
    	$('#defaultCurrencySubmitBtnText').text(submitButtonText);
    });

    $('#profileResetPasswordForm').on('submit', function () {
        $('#profileResetPasswordSubmitBtn').attr("disabled", true);
    	$(".spinner").removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
    	$('#profileResetPasswordSubmitBtnText').text(submitButtonText);
    });

    $('#profileUpdateForm').on('submit', function () {
        $('#profileUpdateSubmitBtn').attr("disabled", true);
    	$(".spinner").removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
    	$('#profileUpdateSubmitBtnText').text(submitButtonText);
    });
}

if ($('.main-containt').find('#cashinCreate').length) {
    function checkFeesLimit(amount, currencyId) {
        $('#cashinCreateSubmitBtn').attr('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: cashinamountLimitUrl,
            method: 'POST',
            data: {
                amount: amount,
                currency_id: currencyId
            },
            success: function(response) {
                if (response.status == 200) {
                    $('#cashinCreateSubmitBtn').attr('disabled', false);
                    let data = response.success;
                    $("#percentage_fee").val(data.feesPercentage);
                    $("#fixed_fee").val(data.feesFixed);    
                    $("#total_fees").val(data.totalFees);
                    $("#total_amount").val(data.totalAmount);
                    $('.fFees').html(data.formattedFeesFixed);
                    $('.pFees').html(data.formattedFeesPercentage);
                    $(".total_fees").html(data.formattedTotalFees);
                    $('#payment_method').val(data.payment_method);
                    $('.amountLimit').text('');
                } else if(response.status == 404) {
                    $('.amountLimit').text(response.message); 
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // On load event
    $(document).ready(function() {
        let amount = $('#amount').val();
        let currencyId = $('#currency_id').val();
        if (amount != '' && currencyId != null) {
            checkFeesLimit(amount, currencyId);
        }
    });

    $('#receiver').on('input', $.debounce(1000,function() {
        let user = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: cashinUserCheckUrl,
            method: 'POST',
            data: {
                user: user,
            },
            success: function(response) {
                console.log(response);
                if (response.status == 200) {
                    $('.receiverError').text('');
                    $('#cashinCreateSubmitBtn').attr('disabled', false); 
                } else if(response.status == 404) {
                    $('.receiverError').text(userNotFoundText); 
                    $('#cashinCreateSubmitBtn').attr('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }));

    // On change event for amount
    $('#amount').on('input', $.debounce(1000,function() {
        let amount = $(this).val();
        let currencyId = $('#currency_id').val();
        if (amount != '' && currencyId != null) {
            checkFeesLimit(amount, currencyId);
        }
    }));

    // On change event for currency_id
    $('#currency_id').on('change', function() {
        let amount = $('#amount').val();
        let currencyId = $(this).val();
        if (amount != '' && currencyId != null) {
            checkFeesLimit(amount, currencyId);
        }
    });

    $(document).on('submit', '#cashinCreateForm', function() {
        $('#cashinCreateSubmitBtn').attr('disabled', true);
        $('.spinner').removeClass('d-none');
        $('#cashinCreateSubmitBtnText').text(submitBtnText);
    });
}

if ($('.main-containt').find('#cashinConfirm').length) {
    $('#cashinConfirmForm').on('submit', function () {
        $('#cashinConfirmBtn').attr("disabled", true);
        $('#cashinConfirmBackBtn').removeAttr('href');
    	$(".spinner").removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
    	$('#cashinConfirmBtnText').text(confirmBtnText);
    });
}

if ($('.main-containt').find('#cashinSuccess').length) {
    $(document).ready(function () {
        // disable browser back button
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };

        // disable F5
        $(document).on("keydown", function (e) {
            if ((e.which || e.keyCode) == 116) {
                e.preventDefault();
            }
        });

        // disable Ctrl+R
        $(document).on("keydown", function (e) {
            if (e.keyCode == 82 && e.ctrlKey) {
                e.preventDefault();
            }
        });
    });
}

if ($('.main-containt').find('#cashoutCreate').length) {
    function handleSearch(user) {
        $("#cashoutCreateSubmitBtn").attr('disabled', true);
        return new Promise(function(resolve, reject) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: currencyListUrl,
                method: 'post',
                data: { user: user },
                success: function (response) {
                    if (response.status == 200) {
                        $("#cashoutCreateSubmitBtn").attr('disabled', false);
                        $(".receiverError").text('');
                        resolve(response.currencyList);
                    } else if (response.status == 404) {
                        $("#currency_id").empty();
                        $(".receiverError").text(userNotFoundText);
                        $("#cashoutCreateSubmitBtn").attr('disabled', true);
                        reject(new Error('User not found.'));
                    }
                }
            });
        });
    }
    
    // Function to populate select dropdown with response data using a promise
    function populateSelect(data) {
        return new Promise(function(resolve, reject) {
            let selectOptions = "";
            // Assuming data is an array of objects with 'value' and 'text' properties
            $.each(data, function (index, item) {
                selectOptions += "<option value='" + item.currency_id + "'>" + item.currency_code + "</option>";
            });
            if(selectOptions !== "") {
                $("#currency_id").html(selectOptions);
                $(".currencyError").text('');
                resolve();
            } else {
                $(".currencyError").text(feeLimitText);
            }
        });
    }

    function checkFeesLimit(amount, currencyId, userId) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: cashoutAmountLimit,
            method: 'POST',
            data: {
                amount: amount,
                currency_id: currencyId,
                user: userId
            },
            success: function(response) {
                if (response.status == 200) {
                    let data = response.success;

                    $("#percentage_fee").val(data.feesPercentage);
                    $("#fixed_fee").val(data.feesFixed);    
                    $("#total_fees").val(data.totalFees);
                    $("#total_amount").val(data.totalAmount);
                    $('.fFees').html(data.formattedFeesFixed);
                    $('.pFees').html(data.formattedFeesPercentage);
                    $(".total_fees").html(data.formattedTotalFees);
                    $('#payment_method').val(data.payment_method);
                    $('.amountLimit').text('');
                    $('#cashoutCreateSubmitBtn').attr('disabled', false);
                } else if(response.status == 404){
                    $('#cashoutCreateSubmitBtn').attr('disabled', true);
                    $('.amountLimit').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Function to handle Ajax request
    $("#user").on('input', function () {
        $("#amount").val('');
        $("#amountLimit").text('');
        let searchTerm = $(this).val().trim();
        if (searchTerm !== '') {
            handleSearch(searchTerm).then(function(data) {
                return populateSelect(data);
            });
        }
    });

    // On change event for amount
    $('#amount').on('input', $.debounce(1000, function() {
        let amount = $(this).val().trim();
        let currencyId = $('#currency_id').val();
        let userId = $('#user').val().trim();
        if (amount != '' && currencyId != null && userId != '') {
            checkFeesLimit(amount, currencyId, userId);
        }
    }));

    // On change event for amount
    $('#currency_id').on('change', function() {
        let currencyId = $(this).val();
        let amount = $('#amount').val().trim();
        let userId = $('#user').val().trim();
        if (amount != '' && currencyId != null && userId != '') {
            checkFeesLimit(amount, currencyId, userId);
        }
    });

    $(document).on('submit', '#cashoutCreateForm', function() {
        $('#cashoutCreateSubmitBtn').attr('disabled', true);
        $('.spinner').removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
        $('#cashoutCreateSubmitBtnText').text(submitBtnText);
    });
}

if ($('.main-containt').find('#cashoutConfirm').length) {

    $("#resendBtn").on('click', function(event){
        event.preventDefault();
        
        $('#cashoutConfirmBtn').attr("disabled", true);
        $('.spinner-border-custom').removeClass('d-none');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: cashoutAmountLimit,
            type: "POST",
            data: {
                user_id: userId
            },
            success: function(response){
                if (response.status == 200) {
                    $('#cashoutConfirmBtn').attr("disabled", false);
                    $('.spinner-border-custom').addClass('d-none');
                }
            },
            error: function(xhr, status, error){
                $("#errorMessage").text("Error sending OTP: " + error);
            }
        });
    });

    $('#cashoutConfirmForm').on('submit', function () {
        $('#cashoutConfirmBtn').attr("disabled", true);
        $('#resendBtn').html('');
        $('#cashoutConfirmBackBtn').removeAttr('href');
    	$(".spinner-confirm").removeClass('d-none');
        $("#rightAngleSvgIcon").addClass('d-none');
    	$('#cashoutConfirmBtnText').text(confirmBtnText);
    });
}

if ($('.main-containt').find('#cashoutSuccess').length) {
    $(document).ready(function () {
        // disable browser back button
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };

        // disable F5
        $(document).on("keydown", function (e) {
            if ((e.which || e.keyCode) == 116) {
                e.preventDefault();
            }
        });

        // disable Ctrl+R
        $(document).on("keydown", function (e) {
            if (e.keyCode == 82 && e.ctrlKey) {
                e.preventDefault();
            }
        });
    });
}

if ($('.main-containt').find('#agentTransaction').length) {
    $(function() {
        let sDate;
        let eDate;
    
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
                endDate: moment(),
    
            }, function (start, end) {
                sDate = moment(start, 'MMMM D, YYYY').format('DD-MM-YYYY');
                $('#startfrom').val(sDate);
                eDate = moment(end, 'MMMM D, YYYY').format('DD-MM-YYYY');
                $('#endto').val(eDate);
                $('#daterange-btn p').html(sDate + ' - ' + eDate);
            }
        )
        
        if (startDate == '') {
            $('#daterange-btn p').html(dateRangePickerText);
        } else {
            $('#daterange-btn p').html(startDate + ' - ' + endDate);
        }
    });
    
    // Transaction
    $(document).ready(function () {
        let type = $('#type').val();
        let currencyId = $('#currency_id').val();
        if (startDate != '' || type != 'all' || currencyId != 'all') {
            $(".filter-panel").css('display', 'block');
        }
    
        $(".fil-btn").on('click', function () {
            $(this).find('img').toggle();
            $(".filter-panel").slideToggle(300);
        });
    });
}
