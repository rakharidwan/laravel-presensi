$(function(){

    absent()

    function absent(){
        $.ajax({
            url:'/data-absent',
            method:'GET',
            success:function(data) {
                console.log(data.absent_count);
                $('#absentEntry').append(data.absent_count)
                $('#absentNotYet').append(data.not_yet_absent)
                $.each(data.absent, function(val, absent) {
                    $.each(absent.karyawan, function(val, karyawan) {
                        $('#absentName').append(karyawan.nama+`( `+karyawan.entitas+` )`)
                    });
                });
            }
        })
    }

})