// Jam digital
function updateClock() {
    let now = new Date();
    let dayName = now.getDay();
    let month = now.getMonth();
    let dayNum = now.getDate();
    let year = now.getFullYear();
    let hour = now.getHours();
    let minute = now.getMinutes();
    let second = now.getSeconds();
    let period = "AM";

    if (hour == 0) {
        hour = 12;
    }

    if (hour > 12) {
        hour = hour - 12;
        period = "PM";
    }

    Number.prototype.pad = function (digits) {
        for (var n = this.toString(); n.length < digits; n = 0 + n);
        return n;
    };

    let mouths = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "juni",
        "juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    let days = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jum'at",
        "Sabtu",
    ];
    let ids = [
        "dayname",
        "month",
        "daynum",
        "year",
        "hour",
        "minutes",
        "seconds",
        "period",
    ];
    let values = [
        days[dayName],
        mouths[month],
        dayNum.pad(2),
        year,
        hour.pad(2),
        minute.pad(2),
        second.pad(2),
        period,
    ];

    for (let i = 0; i < ids.length; i++) {
        document.getElementById(ids[i]).firstChild.nodeValue = values[i];
    }
}

function initClock() {
    updateClock();
    window.setInterval("updateClock()", 1);
}

// Hasil foto
const ambilGambar = document.getElementById("my_camera");
const btnCamera = document.getElementById("btn-camera");
const btnRefresh = document.getElementById("btn-refresh");
let photo = "";

btnCamera.addEventListener("click", function () {
    ambilGambar.style.display = "none";
    btnCamera.style.display = "none";
    btnRefresh.style.display = "block";
    photo = document.getElementById("photo");

    // Btn refresh click
    btnRefresh.addEventListener("click", function () {
        btnCamera.style.display = "block";
        btnRefresh.style.display = "none";
        photo.style.display = "none";
        ambilGambar.style.display = "block";
    });
});
