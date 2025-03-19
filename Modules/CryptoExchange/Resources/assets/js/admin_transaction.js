"use strict";

if ($('.content').find('#crypto_exchange_list').length) {

    $(".select2").select2({});

    $(document).ready(function() {

        $('#user').autocomplete({
            source: function(req, res) {
                if (req.term.length > 0) {
                    $.ajax({
                        url: ajaxUrl,
                        dataType: 'json',
                        type: 'get',
                        data: {
                            search: req.term
                        },
                        success: function(response) {

                            $('form').find("button[type='submit']").prop('disabled',
                                true);

                            if (response.status == 'success') {
                                res($.map(response.data, function(item) {
                                    return {
                                        user_id: item
                                        .user_id,
                                        first_name: item
                                        .first_name,
                                        last_name: item
                                        .last_name,
                                        value: item.first_name + ' ' + item
                                            .last_name
                                    }
                                }));
                            } else if (response.status == 'fail') {
                                $('#error-user').addClass('text-danger').html(
                                    userDoesntExist);
                            }
                        }
                    })
                } else {
                    $('#user_id').val('');
                }
            },
            select: function(event, ui) {
                var e = ui.item;

                $('#error-user').html('');

                $('#user_id').val(e.user_id);

                $('form').find("button[type='submit']").prop('disabled', false);
            },
            minLength: 0,
            autoFocus: true
        });
    });
}

if ($('.content').find('#transaction_edit').length) {
    $(".select2").select2({});
    $(document).on('submit', '#exchange_form', function() {
        $("#exchange_edit").attr("disabled", true);
        $('#cancel_anchor').attr("disabled", "disabled");
        $(".fa-spin").removeClass("d-none");
        $("#exchange_edit_text").text(updateText);    
    });
}

if ($('.content').find('#crypto_module_settings').length) {
    $(document).on('submit', '#crypto_settings', function() {
        $(".fa-spin").removeClass("d-none");
        $("#preference-submit-text").text(updateText);
    });
}



