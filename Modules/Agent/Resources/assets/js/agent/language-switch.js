'use strict';

$(document).ready(function() {
    $("#select_language").on("change", function() {
        if($("#select_language select").val() == 'ar'){
            localStorage.setItem('lang', 'ar');
            let lang = $("#select_language select").val();

            $.ajax({
                type: 'get',
                url: languageSwitchUrl,
                data: {lang: lang},
                success: function (msg) {
                    if (msg == 1) {
                        location.reload();
                        $("html").attr("dir", "rtl");
                    }
                }
            });

        } else {
            let lang = $("#select_language select").val();
            $.ajax({
                type: 'get',
                url: languageSwitchUrl,
                data: {lang: lang},
                success: function (msg) {
                    if (msg == 1) {
                        location.reload()
                        localStorage.setItem('lang', lang);
                        $("html").removeAttr("dir", "rtl");
                    }
                }
            });
        }
    });
});