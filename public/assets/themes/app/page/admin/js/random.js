const TIME_LIMIT = 2;
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;

$(function () {
    'use strict';

    $(document).on("click", "#btn_random", function (e) {
        e.preventDefault();
        startRandom();
        $.ajax({
            url: base_api + "/random/v1?token="+_token,
            type: "GET",
            success: function(response) {
                setTimeout(function() {
                    onTimesUp();
                    $(".count-test").removeClass('on-random');
                    $("#count_test_" + response.data).addClass('on-random');

                    setTimeout(function() {
                        run_waitMe('.wait-containter');
                        window.location.replace(base_admin + "/examination/" + response.data + "/1");
                    }, 500);
                }, 2000);
            },
            error: function(error) {
                onTimesUp();
                run_waitMe('.wait-containter', true);
                Swal.fire({
                    text: error.responseJSON.msg
                });
            }
        });
    });
});

function onTimesUp() {
    clearInterval(timerInterval);
}

function startRandom() {
    timerInterval = setInterval(() => {
        timePassed = timePassed += 0.1;
        timeLeft = TIME_LIMIT - timePassed;
        let rndInt = randomIntFromInterval(1, count_test);
        $(".count-test").removeClass('on-random');
        $("#count_test_" + rndInt).addClass('on-random');
    }, 100);
}


function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min)
}