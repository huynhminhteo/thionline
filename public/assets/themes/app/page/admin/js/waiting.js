var now = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
const TIME_LIMIT = moment(time_start).diff(now, 'seconds');
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;

document.getElementById("countdown_exam").innerHTML = formatTime(timeLeft);

startTimer();

function onTimesUp() {
    clearInterval(timerInterval);
}

function startTimer() {
    timerInterval = setInterval(() => {
        timePassed = timePassed += 1;
        timeLeft = TIME_LIMIT - timePassed;
        document.getElementById("countdown_exam").innerHTML = formatTime(timeLeft);

        if (timeLeft === 0) {
            onTimesUp();
            run_waitMe('.wait-containter');
            window.location.replace(base_admin + "/random");
        }
    }, 1000);
}

function formatTime(time) {
    let hours = Math.floor(time / 3600);
    let minutes = Math.floor(time / 60) - (hours * 60);
    let seconds = time % 60;

    if (hours < 10) {
        hours = `0${hours}`;
    }
    if (minutes < 10) {
        minutes = `0${minutes}`;
    }
    if (seconds < 10) {
        seconds = `0${seconds}`;
    }

    return `<div class="csvg-digit" data-tad-bind="hours">\
                <div id="el_h1" class="csvg-digit-number edit">${hours}</div>\
                <div id="el_h1t" class="csvg-digit-label">hours</div>\
            </div>\
            <div class="csvg-digit" data-tad-bind="minutes">\
                <div id="el_m1" class="csvg-digit-number edit">${minutes}</div>\
                <div id="el_m1t" class="csvg-digit-label">minutes</div>\
            </div>\
            <div class="csvg-digit" data-tad-bind="seconds">\
                <div id="el_s1" class="csvg-digit-number edit">${seconds}</div\
                ><div id="el_s1t" class="csvg-digit-label">seconds</div>\
            </div>`;
}