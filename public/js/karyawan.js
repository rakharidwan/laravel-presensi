$('#karyawanCreateModalButton').on('click', function(){
    $('.error-text').text("");
    $("#karyawanCreateForm").trigger('reset');
})

$("#karyawanCreateButton").on("click", function (e) {
    $(this).empty()
    $(this).attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="sr-only">Memuat...</span>`)
    e.preventDefault();
    createKaryawan();
});

$('#karyawanCreateForm').on('submit', function(e){
    $('#karyawanCreateButton').empty()
    $('#karyawanCreateButton').attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="sr-only">Memuat...</span>`)
    e.preventDefault();
    createKaryawan();
})

function createKaryawan(){
    $.ajax({
        url: $('#karyawanCreateForm').attr("action"),
        method: $('#karyawanCreateForm').attr("method"),
        data: new FormData(document.getElementById("karyawanCreateForm")),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.error-text").text("");
        },
        success: function (data) {
            if (data.status == 0) {
                $('#karyawanCreateButton').removeAttr("disabled")
                $('#karyawanCreateButton').empty()
                $('#karyawanCreateButton').html(`Simpan`)
                $.each(data.error, function (prefix, val) {
                    $("span." + prefix + "_error").text(val[0]);
                    console.log(val[0]);
                });
            } else {
                window.location.href = "/karyawan";
            }
        },
    });
}

let click2 = document.querySelectorAll('.edit')
    document.addEventListener('click', function(event) {
        let id = event.target.getAttribute('data-id')
        $("#jabatanEditForm").trigger('reset');
        $('.error-text').text("");
    $.ajax({
        url: `karyawan/edit/${id}`,
        method: `GET`,
        success: function (data) {
            $('input[name="nik"]').val(data.karyawan.nik);
            $('input[name="nama"]').val(data.karyawan.nama);
            $('input[name="nomor_hp"]').val(data.karyawan.nomor_hp);
            $('select[name="jabatan"]').val(data.karyawan.id_jabatan).change();
            $('input[name="entitas"]').val(data.karyawan.entitas);
            $('#karyawanUpdateForm').attr('action',`/karyawan/perbarui/${id}`)
        },
    });
})

$("#karyawanUpdateButton").on("click", function (e) {
    $(this).empty()
    $(this).attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="sr-only">Memuat...</span>`)
    e.preventDefault();
    updateKaryawan();
});

$('#karyawanUpdateForm').on('submit', function(e){
    $('#karyawanUpdateButton').empty()
    $('#karyawanUpdateButton').attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span class="sr-only">Memuat...</span>`)
    e.preventDefault();
    updateKaryawan();
})

function updateKaryawan(){
    $.ajax({
        url: $('#karyawanUpdateForm').attr("action"),
        method: $('#karyawanUpdateForm').attr("method"),
        data: new FormData(document.getElementById("karyawanUpdateForm")),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.error-text").text("");
        },
        success: function (data) {
            if (data.status == 0) {
                $('#karyawanUpdateButton').removeAttr("disabled")
                $('#karyawanUpdateButton').empty()
                $('#karyawanUpdateButton').html(`Simpan`)
                $.each(data.error, function (prefix, val) {
                    $("span." + prefix + "_error").text(val[0]);
                    console.log(val[0]);
                });
            } else {
                window.location.href = "/karyawan";
            }
        },
    });
}