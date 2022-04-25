$(function () {
    $("#next-page").on("click", function (e) {
        $(this).empty();
        $(this).attr(
            "disabled",
            "disabled"
        ).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`);
        e.preventDefault();
        $.ajax({
            url: "/validate-nik",
            method: "POST",
            data: new FormData(document.getElementById("absentForm")),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    // $.each(data.error, function (prefix, val) {
                    //     $("span." + prefix + "_error").text(val[0]);
                    //     console.log(val[0]);
                    // });
                    $("#msg").html("");
                    $("#msg").append(
                        `
                        <div class="text-center mb-3">
                            <span class="text-` +
                            data.alert +
                            `">` +
                            data.message +
                            `</span>
                        </div>
                    `
                    );
                    $("#next-page").empty();
                    $("#next-page")
                        .removeAttr("disabled")
                        .html('<i class="bi bi-arrow-right"></i>');
                } else {
                    Next();
                    $("#msg").html("");
                    $("#secondForm").removeClass("d-none");
                    $("#firstForm").hide();
                    $("#js").append(`<script language="JavaScript">
                    Webcam.set({
                        image_format: 'jpeg',
                        jpeg_quality: 100
                    });
                    Webcam.attach( '#my_camera' );
                    </script>`);
                    $("#next-page").empty();
                    $("#next-page")
                        .removeAttr("disabled")
                        .html('<i class="bi bi-arrow-right"></i>');
                }
            },
        });
    });

    $("#absentForm").on("submit", function (e) {
        $("#absentButton").empty();
        $("#absentButton").attr(
            "disabled",
            "disabled"
        ).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`);
        e.preventDefault();
        console.log("success");
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $("#msg").html("");
                    $("#msg").append(
                        `
                    <div class="mt-2 mb-2">
                      <div class="alert alert-light alert-dismissible text-danger">
                        ` +
                            data.message +
                            `
                      </div>
                    </div>
                    `
                    );
                    $("#absentButton").empty();
                    $("#absentButton").removeAttr("disabled").html("Masuk");
                    absentError();
                } else {
                    $("#msg").html("");
                    $("#msg").append(
                        `
                    <div class="mt-2 mb-2">
                      <div class="alert alert-light alert-dismissible text-success">
                      ` +
                            data.message +
                            `
                      </div>
                    </div>
                    `
                    );
                    $("#absentButton").empty();
                    $("#absentButton").removeAttr("disabled").html("Masuk");
                    Done();
                }
            },
        });
    });

    $("#prevButton").on("click", function () {
        Back();
        $("#js").html("");
    });
});

// Form wizard
let lebarHalaman = window.innerWidth;
const pagePresensi = document.getElementById("page-presensi");
const presensi = document.getElementById("form-presensi");
const formNik = document.getElementById("form-nik");
const formKamera = document.getElementById("form-kamera");
const btnNext = document.getElementById("next-page");
const btnBack = document.getElementById("pre-page");
const progress = document.getElementById("progress");
const step2 = document.getElementById("step2");
const camera = document.getElementById("my_camera");

window.addEventListener("resize", function () {
    lebarHalaman = window.innerWidth;
    if (lebarHalaman > 768) {
        camera.style.width = "360px";
    }
});

function Next() {
    lebarHalaman = window.innerWidth;
    formNik.style.marginLeft = "1000px";
    formKamera.style.margin = "auto";
    presensi.style.height = "650px";
    progress.style.width = "100%";
    step2.style.color = "#fff";
}

function Back() {
    lebarHalaman = window.innerWidth;
    formNik.style.margin = "auto";
    formKamera.style.marginLeft = "1000px";
    presensi.style.height = "400px";
    progress.style.width = "50%";
    step2.style.color = "#333";
    pagePresensi.style.marginTop = "0";
}

function Done() {
    lebarHalaman = window.innerWidth;
    formNik.style.margin = "auto";
    formKamera.style.marginLeft = "650px";
    presensi.style.height = "530px";
    pagePresensi.style.marginTop = "0";
    progress.style.width = "50%";
    step2.style.color = "#333";
}

function absentError() {
    lebarHalaman = window.innerWidth;
    formNik.style.margin = "auto";
    formKamera.style.marginLeft = "650px";
    presensi.style.height = "530px";
    progress.style.width = "50%";
    step2.style.color = "#333";
    pagePresensi.style.marginTop = "0";
}
