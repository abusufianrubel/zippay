"use strict";

const deadline = Date.now() + 300000; // Set deadline 5 minutes from now

const intervalId = setInterval(updateTimer, 1000);

function updateTimer() {
    const now = Date.now();
    const timeLeft = deadline - now;

    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    const progressBar = document.querySelector('#progressBar');
    const totalSeconds = 300; // 5 minutes in seconds
    const remainingSeconds = timeLeft * 0.001;
    progressBar.style.width = (remainingSeconds * 100 / totalSeconds) + "%";

    document.getElementById("timer").innerHTML = `${minutes}m : ${seconds}s`;

    if (timeLeft <= 0) {
        clearInterval(intervalId);
        progressBar.style.width = 0 + "%";
        document.getElementById("timer").innerHTML = expireText;
        $("#cashoutConfirmBtn").prop("disabled", true);
    }
}
