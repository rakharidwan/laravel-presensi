$(function(){

    $("#jabatanCreateButton").on("click", function (e) {
        $(this).empty()
        $(this).attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`)
        e.preventDefault();
        createJabatan();
    });

    $('#jabatanCreateForm').on('submit', function(e){
        $('#jabatanCreateButton').empty()
        $('#jabatanCreateButton').attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`)
        e.preventDefault();
        createJabatan();
    })

    $('#jabatanCreateModalButton').on('click', function(){
        $('.error-text').text("");
        $("#jabatanCreateForm").trigger('reset');
    })

    let click2 = document.querySelectorAll('.edit')
    document.addEventListener('click', function(event) {
        let id = event.target.getAttribute('data-id')
        $("#jabatanEditForm").trigger('reset');
        $('.error-text').text("");
        console.log(id);
        $.ajax({
            url:`/jabatan/ubah/${id}`,
            method:'GET',
                success: function (data){
                    $('#editJabatan').html(`
                    <input type="text" name="jabatan" value="${data.jabatan.jabatan}" id="edit-jabatan" class="form-control">
                    `)
                    $('#jabatanEditForm').attr('action',`/jabatan/perbarui/${id}`)
            }
        })

    })
    
    function createJabatan(){
        $.ajax({
            url: $('#jabatanCreateForm').attr("action"),
            method: $('#jabatanCreateForm').attr("method"),
            data: new FormData(document.getElementById("jabatanCreateForm")),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $('#jabatanCreateButton').removeAttr("disabled")
                    $('#jabatanCreateButton').empty()
                    $('#jabatanCreateButton').html(`Simpan`)
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                        console.log(val[0]);
                    });
                } else {
                    window.location.href = "/jabatan";
                }
            },
        });
    }

    $("#jabatanUpdateButton").on("click", function (e) {
        e.preventDefault();
        $(this).empty()
        $(this).attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`)
        updateJabatan();
    });

    $('#jabatanEditForm').on('submit', function(e){
        $('#jabatanUpdateButton').empty()
        $('#jabatanUpdateButton').attr("disabled", "disabled").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Memuat...</span>`)
        e.preventDefault();
        updateJabatan();
    })

    function updateJabatan(){
        $.ajax({
            url: $('#jabatanEditForm').attr("action"),
            method: $('#jabatanEditForm').attr("method"),
            data: new FormData(document.getElementById("jabatanEditForm")),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (data) {
                if (data.status == 0) {
                    $('#jabatanUpdateButton').removeAttr("disabled")
                    $('#jabatanUpdateButton').empty()
                    $('#jabatanUpdateButton').html(`Simpan`)
                    $.each(data.error, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                        console.log(val[0]);
                    });
                } else {
                    window.location.href = "/jabatan";
                }
            },
        })
    }
})