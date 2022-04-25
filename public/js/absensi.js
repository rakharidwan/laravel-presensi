$(function(){
    $('.image').on('click', function(){
        let id = $(this).data('id');
        $.ajax({
            url: `absensi/image/${id}`,
            method: `GET`,
            success: function (data) {
                $('.modal-body').html(`
                <img src="storage/`+data.absensi.foto+`" alt="">
                `)
            },
        });
    })
    
})