const TIME_LIMIT = 2;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;

$(function () {
    'use strict';

    $('.content-exam').toggle();

    $(document).on("click", ".name-user", function (e) {
        var $el = $(this);
        e.preventDefault();
        $el.parent().find('.content-exam').toggle(function () {
            if ($(this).is(':visible')) {
                $el.addClass("active");
            } else {
                $el.removeClass("active");
            }
        });
    });
});