$(function() {
    'use strict';

    $(document).on('click', '.change-password', function(event) {
        resetFormChangePassword();
        $('#modal_change_password').modal('show');
    });

    // $(document).on('click', '#modal_change_password #btnSubmit', function(e) {
    //     e.preventDefault();
    //     $('#ChangePassForm').submit();
    // });

    // $(document).on('submit', '#ChangePassForm', function(e) {
    //     e.preventDefault();
    //     var form = $(this);
    //     form.parsley().validate();
    //     if (form.parsley().isValid()) {
    //         ChangePassFormSubmit();
    //     }
    // });
});

var resetFormChangePassword = function(type) {
    $('#ChangePassForm #oldpass').val('');
    $('#ChangePassForm #newpass').val('');
    $('#ChangePassForm #newpass_confirmation').val('');
    $("#ChangePassForm").parsley().reset();
}


// var ChangePassFormSubmit = function() {
//     run_waitMe('.signin-box');
//     $.ajax({
//         url: base_api + "/changepw_admin/v1?token="+_token,
//         type: "POST",
//         data: $('#ChangePassForm').serialize(),
//         success: function(response) {
//             run_waitMe('.signin-box', true);
//             Swal.fire({
//                 text: response.msg
//             });
//             $('#modal_change_password').modal('hide');
//         },
//         error: function(error) {
//             run_waitMe('.signin-box', true);
//             Swal.fire({
//                 text: error.responseJSON.msg
//             });
//         }
//     });
// }

var changePageLength = function(el, table, length) {
    if ($.fn.DataTable.isDataTable(el)) {
        if ($.isArray(length)) {
            table.page.len(length[0]).draw();
        } else {
            table.page.len(length).draw();
        }
    }
  }