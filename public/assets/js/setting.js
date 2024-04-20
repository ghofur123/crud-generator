$(document).on('DOMContentLoaded', function () {
    loadBrand();
    loadMenuData();
    
});

$(document).on('click', '.nav-link', function () {
    $('.loader').show();
    let dataUrl = $(this).attr('data');

    let dataIndex = $(this).attr('data-index');
    localStorage.setItem('svindx', dataIndex);

    getDataFromApi(dataUrl, 'GET', "", function (result) {
        resultData(result);
        $('.loader').hide();
    });
});

function loadMenuData() {
    getDataFromApi('api/setting/json-data', 'GET', '', function (data) {
        let menu = data.menu;
        let navClass = "";
        let isFirstDefaultProcessed = false;

        Object.keys(menu).forEach(function (key, index) {
            let capitalizedFirstName = capitalizeFirstLetter(menu[key].name);

            navClass += '<li class="nav-item">' +
                '<a class="nav-link active" aria-current="page" href="#" data="' + menu[key].url + '" data-index="' + index + '"> ' + capitalizedFirstName + ' </a>' +
                '</li>';
            if (menu[key].default == true && !isFirstDefaultProcessed) {
                // processDefaultData(menu[key].url);
                
                isFirstDefaultProcessed = true;
            }
        });

        $('.menu-class-json').html(navClass);
        $('.loader').hide();
    });
}

function processDefaultData(url) {
    localStorage.setItem('url', url);
    getDataFromApi(url, 'GET', "", function (result) {
        resultData(result);
    });
}

function loadBrand() {
    getDataFromApi('api/setting/json-data', 'GET', '', function (data) {
        let description = data.description;

        $('title').html(description['title']);
        $('.navbar-brand').html(description['brand']);
        $('.offcanvas-title').html(description['simple-brand']);
        
        console.log(description['brand']);
    });
}
