"use strict";

$(".select2").select2();

if ($('.content').find('#cashout').length) {

    $(document).ready(function () {
        let $userInput = $('#user_input');
        let $userId = $('#user_id');
        let $errorUser = $('#error-user');
        let $submitButton = $('form').find("button[type='submit']");
    
        $userInput.on('keyup keypress', function (e) {
            if (e.type === 'keyup' || e.type === 'keypress') {
                if ($userInput.val().length === 0) {
                    $userId.val('');
                    $errorUser.html('');
                    $submitButton.prop('disabled', false);
                }
            }
        });
    
        $userInput.autocomplete({
            source: function (req, res) {
                if (req.term.length > 0) {
                    $.ajax({
                        url: userSearchUrl,
                        dataType: 'json',
                        type: 'get',
                        data: {
                            search: req.term
                        },
                        success: function (response) {
                            $submitButton.prop('disabled', true);
    
                            if (response.status === 'success') {
                                res($.map(response.data, function (item) {
                                    return {
                                        id: item.user_id,
                                        first_name: item.first_name,
                                        last_name: item.last_name,
                                        value: item.first_name + ' ' + item.last_name
                                    };
                                }));
                            } else if (response.status === 'fail') {
                                $errorUser.addClass('text-danger').html(userNotExistText);
                            }
                        }
                    });
                } else {
                    $userId.val('');
                }
            },
            select: function (event, ui) {
                let e = ui.item;
    
                $errorUser.html('');
                $userId.val(e.id);
                $submitButton.prop('disabled', false);
            },
            minLength: 0,
            autoFocus: true
        });
    });
}

if ($('.content').find('#cashoutEdit').length) {
    $(document).on('submit', '#cashOutUpdateForm', function() {
        $('#cashoutUpdateSubmitBtn').attr('disabled', true);
        $('#cashoutUpdateCancelBtn').attr('disabled',true);
        $('.fa-spin').removeClass('d-none');
        $('#cashoutUpdateSubmitBtnText').text(updatingText);
    });
}