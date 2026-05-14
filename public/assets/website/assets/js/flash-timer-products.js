// flash-timer-products.js

const endOfDay = new Date();
endOfDay.setHours(23, 59, 59, 999);

function startCountdown() {
    const now = new Date();
    const diff = endOfDay - now;

    if (diff <= 0) {
        document.getElementById("day").textContent = "00";
        document.getElementById("hour").textContent = "00";
        document.getElementById("minute").textContent = "00";
        document.getElementById("second").textContent = "00";
        return;
    }

    const totalSeconds = Math.floor(diff / 1000);
    const days    = Math.floor(totalSeconds / 86400);
    const hours   = Math.floor((totalSeconds % 86400) / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    document.getElementById("day").textContent    = String(days).padStart(2, '0');
    document.getElementById("hour").textContent   = String(hours).padStart(2, '0');
    document.getElementById("minute").textContent = String(minutes).padStart(2, '0');
    document.getElementById("second").textContent = String(seconds).padStart(2, '0');
}

document.addEventListener("DOMContentLoaded", function () {
    startCountdown();
    setInterval(startCountdown, 1000);
});
