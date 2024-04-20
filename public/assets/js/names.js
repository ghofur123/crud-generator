// Constants for class names
const CARD_CLASS = '.card';
const LOADER_CLASS = '.loader';
const EDIT_BUTTON_CLASS = '.btn-edit-class';
const FORM_INPUT_CLASS = '.form-input-create';
const SEARCH_INPUT_CLASS = '.search-input-form';
const SEARCH_TABLE_CLASS = '.search-table';
const PAGE_LINK_CLASS = '.page-link';
const MODAL_CONTENT_CLASS = '.modal-content-class';
const BUTTON_LOADER_CLASS = '.button-loader-class';
const BUTTON_SUBMIT_CLASS = '.button-submit-class';
const ALERT_WARNING_CLASS = '.alert-warning';
const BTN_SEARCH_CLASS = '.btn-search';
const TABLE_DATA_RESULT_CLASS = '.table-data-result';
const PAGINATION_CLASS = '.pagination';
const GET_METHOD = 'POST';     
const POST_METHOD = 'POST';     
const PUT_METHOD = 'POST';     
const DELETE_METHOD = 'POST';     

// Function to show or hide elements
function showElement(element) {
    $(element).show();
}

function hideElement(element) {
    $(element).hide();
}

// Click event for edit button
$(document).on('click', EDIT_BUTTON_CLASS, function (event) {
    event.preventDefault();
    showElement(LOADER_CLASS);

    $('input[name]').val("");
    let idData = $(this).attr('data');

    getDataFromApi(`api/siswa/${idData}`, 'GET', "", function (result) {
        setValues(result.data);
        hideElement(LOADER_CLASS);
    });

    $(MODAL_CONTENT_CLASS).load('resources/views/template/form_edit.blade.php');
});

// Submit event for form input
$(document).on('submit', FORM_INPUT_CLASS, function (event) {
    event.preventDefault();

    showElement(BUTTON_LOADER_CLASS);
    hideElement(BUTTON_SUBMIT_CLASS);

    let formData = $(this).serialize();
    getDataFromApi('api/siswa', 'POST', formData, function (result) {
        if (!result.success) {
            let errorMessages = result.data;
            let htmlValue = '<ol>';
            for (let field in errorMessages) {
                htmlValue += `<li>${errorMessages[field][0]}</li>`;
            }
            htmlValue += '</ol>';
            $(ALERT_WARNING_CLASS).show().html(htmlValue);
            hideElement(BUTTON_LOADER_CLASS);
            showElement(BUTTON_SUBMIT_CLASS);
        } else {
            getDataFromApi('api/siswa', 'GET', "", function (result) {
                resultData(result);
            });
            $('.modal').modal('hide');
            hideElement(BUTTON_LOADER_CLASS);
            showElement(BUTTON_SUBMIT_CLASS);
        }
        hideElement(LOADER_CLASS);
    });
    return false;
});

// Keyup event for search input
$(document).on('keyup', SEARCH_INPUT_CLASS, function () {
    if ($(this).val().length > 2) {
        showElement(BTN_SEARCH_CLASS);
    } else if ($(this).val().length === 0) {
        getDataFromApi('api/siswa', 'GET', "", function (result) {
            resultData(result);
        });
    } else {
        hideElement(BTN_SEARCH_CLASS);
    }
});

// Submit event for search table form
$(document).on('submit', SEARCH_TABLE_CLASS, function (event) {
    event.preventDefault();
    let data = $(`${SEARCH_TABLE_CLASS} input[name=searchTerm]`).val();
    getDataFromApi(`api/siswa-search?searchTerm=${data}`, 'POST', "", function (result) {
        if (result.data.length === 0) {
            hideElement(LOADER_CLASS);
        } else {
            resultData(result);
        }
    });
    return false;
});

// Click event for pagination links
$(document).on('click', PAGE_LINK_CLASS, function () {
    let dataUrl = $(this).attr('data');
    getDataFromApi(dataUrl, 'GET', "", function (result) {
        resultData(result);
    });
});

// Function to handle the result data
function resultData(data) {
    let result = data.data;
    let metaData = data.meta;
    let tableData = "";

    let columns = Object.keys(result[0]);

    tableData += '<thead>' +
        "<tr>";
    for (let i = 0; i < columns.length; i++) {
        let numberColums = i + 1;

        if (numberColums === columns.length) {
            tableData += '<th>Actions</th>';
        } else {
            tableData += `<th>${columns[i]}</th>`;
        }
    }
    tableData += '</tr>' +
        '</thead>' +
        '<tbody>';
    for (let i = 0; i < result.length; i++) {
        tableData += '<tr>';
        for (let j = 0; j < columns.length; j++) {
            let columnName = columns[j];
            if (columnName !== 'id') {
                tableData += `<td>${result[i][columnName]}</td>`;
            }
        }

        tableData += '<td>' +
            `<button class="btn btn-primary btn-edit-class" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data="${result[i].id}">Edit</button>` +
            '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete">Delete</button>' +
            '</td>';

        tableData += '</tr>';
    }

    let buttonValue = "";
    for (let i = 0; i < metaData.last_page + 2; i++) {
        if (metaData.links[i].active) {
            buttonValue += `<li class="page-item active"><a class="page-link" href="#" data="${metaData.links[i].url}">${metaData.links[i].label}</a></li>`;
        } else {
            buttonValue += `<li class="page-item"><a class="page-link" href="#" data="${metaData.links[i].url}">${metaData.links[i].label}</a></li>`;
        }
    }

    hideElement(LOADER_CLASS);
    showElement(CARD_CLASS);
    $(PAGINATION_CLASS).html(buttonValue);
    $(TABLE_DATA_RESULT_CLASS).html(tableData);
}


const CARD_CLASS = '.card';
const URL_API_SETTING = 'api/setting/json-data';

$(document).on('DOMContentLoaded', function () {
    loadMenuData();
});

$(document).on('click', '.nav-link', function () {
    $('.loader').show();
    let dataUrl = $(this).attr('data');
    getDataFromApi(dataUrl, 'GET', "", function (result) {
        resultData(result);
        $(LOADER_CLASS).hide();
    });
});

function loadMenuData() {
    getDataFromApi(URL_API_SETTING, 'GET', '', function (data) {
        let menu = data.menu;
        let navClass = "";
        let isFirstDefaultProcessed = false;

        Object.keys(menu).forEach(function (key) {
            let capitalizedFirstName = capitalizeFirstLetter(menu[key].name);

            navClass += '<li class="nav-item">' +
                '<a class="nav-link active" aria-current="page" href="#" data="' + menu[key].url + '"> ' + capitalizedFirstName + ' </a>' +
                '</li>';
            if (menu[key].default == true && !isFirstDefaultProcessed) {
                processDefaultData(menu[key].url);
                isFirstDefaultProcessed = true;
            }
        });

        $('.menu-class-json').html(navClass);
    });
}

function processDefaultData(url) {
    getDataFromApi(url, 'GET', "", function (result) {
        resultData(result);
    });
}
