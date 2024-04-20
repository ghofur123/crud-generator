$(document).on('submit', '.login-form', function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: 'api/login',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $(this).serialize(),
        beforeSend: function () {
            $('.loader').show();
            $('.alert-warning').hide();
        },
        success: function (data) {
            $('.loader').hide();
            $('.alert-warning').show();
            if(data.success === false){
                $('.alert-warning').empty().html('Email atau password tidak valid. Silakan coba lagi.');
            } else {
                $('.alert-warning').html('Berhasil');
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan dalam permintaan AJAX: ' + error);
        }
    }).done(function () {
    });
});
