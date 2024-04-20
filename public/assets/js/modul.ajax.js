function getDataFromApi(url, method, formData, callback) {
    $.ajax({
        type: method,
        url: url,
        contentType: 'application/x-www-form-urlencoded',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: formData,
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (data) {
            if (callback && typeof(callback) === "function") {
                callback(data);
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan dalam permintaan AJAX: ' + error);
        }
    }).done(function () {
    });
}