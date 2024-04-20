class ApiHandler {
    constructor() {
        this.csrfToken = $('meta[name="csrf-token"]').attr('content');
        this.loaderClass = '.loader';
    }

    fetchData(url, method, formData, successCallback, errorCallback) {
        $.ajax({
            type: method,
            url: url,
            contentType: 'application/x-www-form-urlencoded',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
            },
            data: formData,
            beforeSend: () => {
                this.showLoader();
            },
            success: (data) => {
                if (successCallback && typeof(successCallback) === "function") {
                    successCallback(data);
                }
            },
            error: (xhr, status, error) => {
                this.showError('Terjadi kesalahan dalam permintaan AJAX: ' + error);
                if (errorCallback && typeof(errorCallback) === "function") {
                    errorCallback(xhr, status, error);
                }
            }
        }).done(() => {
            this.hideLoader();
        });
    }

    showLoader() {
        $(this.loaderClass).show();
    }

    hideLoader() {
        $(this.loaderClass).hide();
    }

    showError(message) {
        alert(message);
    }
}