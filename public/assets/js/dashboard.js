const useUrlHandler = new urlHandler();

$('.card').css('display', 'none');
$('.loader').hide();



$(document).on('click', '.btn-edit-class', function (event) {
    event.preventDefault();
    $('.loader').show();
    console.log($(this).attr('url'))

    $('input[name]').val("");
    let idData = $(this).attr('data');

    getDataFromApi(useUrlHandler.URL_SISWA_API + '/' + idData, 'GET', "", function (result) {
        setValues(result.data);
        $('.loader').hide();
    });

    $('.modal-content-class').load('resources/views/template/form_edit.blade.php');
});
$(document).on('click', '.btn-edit-delete', function(event) {
    event.preventDefault();
    let idData = $(this).attr('data');
    console.log(idData);

    $('.loader').show();
    $('.modal-content-class').load('resources/views/template/form_delete.blade.php', function() {
        $('.loader').hide();
    });
});

$(document).on('submit', '.form-input-create', function (event) {
    event.preventDefault();

    $('.button-loader-class').show();
    $('.button-submit-class').hide();

    let formData = $(this).serialize();
    getDataFromApi(useUrlHandler.URL_SISWA_API, 'POST', formData, function (result) {
        if (result.success == false) {
            let errorMessages = result.data;
            let htmlValue = '<ol>';
            for (let field in errorMessages) {
                htmlValue += '<li>' + errorMessages[field][0] + '</li>';
            }
            htmlValue += '</ol>';
            $('.alert-warning').show().html(htmlValue);
            $('.button-loader-class').hide();
            $('.button-submit-class').show();
        } else {
            getDataFromApi('api/siswa', 'GET', "", function (result) {
                resultData(result);
            });
            $('.modal').modal('hide');
            $('.button-loader-class').hide();
            $('.button-submit-class').show();
        }
        $('.loader').hide();
    });
    return false;
});
$(document).on('submit', '.form-input-edit', function (event) {
    event.preventDefault();

    $('.button-loader-class').show();
    $('.button-submit-class').hide();
    let idFormEdit = $('#id-form-edit').val();
    let formData = $(this).serialize();
    getDataFromApi(useUrlHandler.URL_SISWA_API + '/' + idFormEdit , 'PUT', formData, function (result) {
        if (result.success == false) {
            let errorMessages = result.data;
            let htmlValue = '<ol>';
            for (let field in errorMessages) {
                htmlValue += '<li>' + errorMessages[field][0] + '</li>';
            }
            htmlValue += '</ol>';
            $('.alert-warning').show().html(htmlValue);
            $('.button-loader-class').hide();
            $('.button-submit-class').show();
        } else {
            getDataFromApi('api/siswa', 'GET', "", function (result) {
                resultData(result);
            });
            $('.modal').modal('hide');
            $('.button-loader-class').hide();
            $('.button-submit-class').show();
        }
        $('.loader').hide();
    });
    return false;
});
$(document).on('keyup', '.search-input-form', function () {
    if ($(this).val().length > 2) {
        $('.btn-search').show();
    } else if ($(this).val().length == 0) {
        getDataFromApi(useUrlHandler.URL_SISWA_API, 'GET', "", function (result) {
            resultData(result);
        });
    } else {
        $('.btn-search').hide();
    }
});

$(document).on('submit', '.search-table', function (event) {
    event.preventDefault();
    let data = $('.search-table input[name=searchTerm]').val();
    getDataFromApi('api/siswa-search?searchTerm=' + data, 'POST', "", function (result) {
        console.log(result.data.length);
        if (result.data.length == 0) {
            $('.loader').hide();
        }
        else {
            resultData(result);
        }
    });
    return false;
});

$(document).on('click', '.page-link', function () {
    let dataUrl = $(this).attr('data');
    getDataFromApi(dataUrl, 'GET', "", function (result) {
        resultData(result);
    });
});

function resultData(data) {
    let result = data.data;
    let links = data.links;
    let metaData = data.meta;
    let tableData = "";

    let columns = Object.keys(result[0]);

    tableData += '<thead>' +
        "<tr>";
    for (let i = 0; i < columns.length; i++) {
        let numberColums = i + 1;

        if (numberColums == columns.length) {
            tableData += '<th>Actions</th>';
        } else {
            tableData += '<th>' + columns[numberColums] + '</th>';
        }
    }
    tableData += '</tr>' +
        '</thead>' +
        '<tbody>';
    for (let i = 0; i < result.length; i++) {
        tableData += '<tr>';
        for (let j = 0; j < columns.length; j++) {
            let columnName = columns[j];
            if (columnName == 'id') {
            }else {
                tableData += '<td>' + result[i][columnName] + '</td>';
            }
        }

        tableData += '<td>' +
            '<button class="btn btn-primary btn-edit-class" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data="' + result[i].id + '">Edit</button>' +
            '<button class="btn btn-danger btn-edit-delete" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data="' + result[i].id + '">Delete</button>' +
            '</td>';

        tableData += '</tr>';
    }

    let buttonValue = "";
    for (let i = 0; i < metaData.last_page + 2; i++) {
        if (metaData.links[i].active == true) {
            buttonValue += '<li class="page-item active"><a class="page-link" href="#" data="' + metaData.links[i].url + '">' + metaData.links[i].label + '</a></li>';
        } else {
            buttonValue += '<li class="page-item"><a class="page-link" href="#" data="' + metaData.links[i].url + '">' + metaData.links[i].label + '</a></li>';
        }
    }

    $('.loader').hide();
    $('.card').show();
    $('.pagination').html(buttonValue);
    $('.table-data-result').html(tableData);
}