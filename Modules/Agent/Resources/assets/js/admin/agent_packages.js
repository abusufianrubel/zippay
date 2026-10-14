"use strict";

if ($('.content').find('#packageCreate').length) {
    $("#packageCreateForm").on("submit", function () {
        $('#packageCreateSubmitBtn').attr("disabled", true);
        $(".fa-spin").removeClass('d-none');
        $('#packageCreateSubmitBtnText').text(submitButtonText);
    });
}

if ($('.content').find('#agentPackageEdit').length) {
    $("#agentPackageEditForm").on("submit", function () {
        $('#agentPackageEditSubmitBtn').attr("disabled", true);
        $(".fa-spin").removeClass('d-none');
        $('#agentPackageEditSubmitBtnText').text(submitButtonText);
    });
}