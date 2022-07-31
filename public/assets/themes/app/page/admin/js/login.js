$(function () {
    'use strict';

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('click', '#btnLogin', function (e) {
        e.preventDefault();
        $('#formLogin').submit();
    });

    $(document).on('click', '#btnChangePassword', function (e) {
        e.preventDefault();
        $('#changePasswordForm').submit();
    });
    
    $(document).on('click', '#btnForgot', function (e) {
        e.preventDefault();
        $('#forgotForm').submit();
    });

    $(document).on('click', '#btnForgotChangePW', function (e) {
        e.preventDefault();
        $('#formForgotChangePW').submit();
    });

    $(document).on('click', '#btn_change_pw', function (e) {
        e.preventDefault();
        $('#ChangePassForm').submit();
    });

    $("#formLogin").on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            LoginFormSubmit();
        }
    });

    $("#forgotForm").on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            ForgotFormSubmit();
        }
    });

    $("#formForgotChangePW").on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            ForgotChangePWFormSubmit();
        }
    });

    $('#ChangePassForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            ChangePassFormSubmit();
        }
    });

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            changePasswordSubmit();
        }
    });

});


var LoginFormSubmit = function () {
    run_waitMe('.signin-box');
    var data = $('#formLogin').serialize();
    $.ajax({
        url: base_ajax + "/login",
        type: "POST",
        data: data,
        success: function (response) {
            if (response.code != 200) {
                run_waitMe('.signin-box', true);
                Swal.fire({
                    text: response.msg
                });
            } else {
                location.reload();
            }
        },
        error: function(error) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
    $('.password').val('');
};

var ForgotFormSubmit = function () {
    run_waitMe('.signin-box');
    $.ajax({
        url: base_ajax + "/forgot",
        type: "POST",
        data: $('#forgotForm').serialize(),
        success: function (response) {
            if (response.code === 200) {
                run_waitMe('.signin-box', true);
                Swal.fire({
                    text: response.msg
                }).then(function () {
                    window.location = base_admin;
                });
            } else {
                run_waitMe('.signin-box', true);
                Swal.fire({
                    text: response.msg
                });
            }
        },
        error: function(error) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: error.msg
            });
        }
    });
};

var ForgotChangePWFormSubmit = function () {
    run_waitMe('.signin-box');
    $.ajax({
        url: base_ajax + "/forgot-submit",
        type: "POST",
        data: $('#formForgotChangePW').serialize(),
        success: function (response) {
            if (response.code === 200) {
                run_waitMe('.signin-box', true);
                // Swal.fire({
                //     text: response.msg
                // }).then(function (result) {
                //     if (result.value) {
                        window.location = base_admin;
                //     }
                // });
            } else {
                run_waitMe('.signin-box', true);
                Swal.fire({
                    text: response.msg
                });
            }
        },
        error: function(error) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
};

var changePasswordSubmit = function () {
    run_waitMe('.signin-box');
    $.ajax({
        url: base_api + "/reset-password/v1",
        type: "POST",
        data: $('#changePasswordForm').serialize(),
        success: function (response) {
            Swal.fire({
                text: response.msg
            }).then(function () {
                window.location = base_admin;
            });
        },
        error: function(error) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
}

var ChangePassFormSubmit = function() {
    run_waitMe('.signin-box');
    $.ajax({
        url: base_api + "/change-password/v1?token="+_token,
        type: "POST",
        data: $('#ChangePassForm').serialize(),
        success: function(response) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: response.msg
            }).then(function () {
                window.history.back();
            });
        },
        error: function(error) {
            run_waitMe('.signin-box', true);
            Swal.fire({
                text: error.responseJSON.msg
            });
        }
    });
}