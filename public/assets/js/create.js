let dataIndex = localStorage.getItem('svindx');
$(document).on('click', '.btn-input-class', function (event) {
    event.preventDefault();
    $('.loader').show();
    $('.modal-content-class').load('resources/views/template/form_create.blade.php', function() { 
    });
    let form = "";
    form += "<div class='alert alert-warning' role='alert' style='display: none;'></div>";

    getDataFromApi('api/setting/json-data', 'GET', "", function (result) {
        let menu = result.menu;
        let promises = []; // Menyimpan semua promise

        for(let i = 0; i < menu[dataIndex]['form'].length; i++){
            let typeForm = menu[dataIndex]['type'][i];
            let nameForm = menu[dataIndex]['form'][i];
            // berupa form text
            if(typeForm == 'text'){

                form += "<div class='mb-3'>"+
                    "<label for='"+ nameForm +"' class='form-label'>"+ nameForm +"</label>"+
                    "<input type='"+ typeForm +"' name='"+ nameForm +"' class='form-control' id='"+ nameForm +"' placeholder='"+ nameForm +"'>"+
                "</div>";

            }else if(typeForm == 'textarea'){

                form += "<div class='mb-3'>"+
                    "<label for='"+ nameForm +"' class='form-label'>"+ nameForm +"</label>"+
                    "<textarea class='form-control' id='"+ nameForm +"' rows='3'></textarea>"+
                "</div>";

            }else{

                let typeFormSelect = menu[dataIndex][typeForm]['type'];
                let valueFormSelect = menu[dataIndex][typeForm]['value'];
                // select statik / tetap / tidak mengambil data dari database
                if(typeFormSelect == 'select'){
                    form += "<div class='mb-3'>"+
                        "<select class='form-select form-select-sm' aria-label='Small select example' name='"+ nameForm +"'>"+
                            "<option selected>Open this select "+ nameForm +"</option>";
                            for(let ii = 0; ii < valueFormSelect.length; ii++){
                                form +="<option value='"+ valueFormSelect[ii] +"'>"+ menu[dataIndex][typeForm]['option'][ii] +"</option>";
                            }
                        form +="</select>"+
                    "</div>";
                }else if(typeFormSelect == 'select_api'){

                    let urlForm = menu[dataIndex][typeForm]['url'];

                    let promise = new Promise((resolve, reject) => {
                        getDataFromApi(urlForm, 'GET', "", function (result) {

                            let selectOptions = "<option selected>Open this select "+ nameForm +"</option>";
                            for(let iii = 0; iii < result.value.length; iii++){
                                selectOptions +="<option value='"+ result.value[iii] +"'>"+ result.option[iii] +"</option>";
                            }
                            form += "<div class='mb-3'>"+
                                    "<select class='form-select form-select-sm' aria-label='Small select example' name='"+ nameForm +"'>" + 
                                        selectOptions+
                                    "</select>"+
                                "</div>";
                            resolve();

                        });
                    });
                    promises.push(promise);
                }else if(typeFormSelect == 'select_action_to'){

                    let urlForm = menu[dataIndex][typeForm]['url'];
                    let nameActTo = menu[dataIndex][typeForm]['name_action_to'];

                    let promise = new Promise((resolve, reject) => {
                        getDataFromApi(urlForm, 'GET', "", function (result) {
                            let selectOptions = "<option selected>Open this select "+ nameForm +"</option>";
                            for(let iiii = 0; iiii < result.value.length; iiii++){
                                selectOptions +="<option value='"+ result.value[iiii] +"'>"+ result.option[iiii] +"</option>";
                            }
                            form += "<div class='mb-3 select-action-class'>"+
                                "<select class='form-select form-select-sm select-action-to' aria-label='Small select example' name='"+ nameForm +"' data='"+ nameActTo +"'>" + 
                                    selectOptions + 
                                "</select>"+
                            "</div>";
                            resolve();
                        });
                    });
                    promises.push(promise);

                }
            }
        }

        Promise.all(promises).then(() => {
            // Eksekusi kode setelah semua promise selesai
            $('.modal-form-create').html(form);
            $('.loader').hide();
        });
    });
});


var isElementAdded = false;

$(document).on('change', '.select-action-to', function(event){
    let nameMenu = $(this).attr('data');
    let valueData = $(this).val();
    
    if (!isElementAdded) {
        getDataFromApi('api/setting/json-data', 'GET', "", function (result) {
            let menu = result.menu;
            let urlForm = menu[dataIndex][nameMenu]['url'];
            console.log(urlForm + "/" + valueData);
            getDataFromApi(urlForm + "/" + valueData, 'GET', "", function (result) {

                let selectOptions = "<option selected>Open this select</option>";
                for(let iii = 0; iii < result.value.length; iii++){
                    selectOptions +="<option value='"+ result.value[iii] +"'>"+ result.option[iii] +"</option>";
                }
                let frm = "<div class='mb-3'>"+
                        "<select class='form-select form-select-sm' aria-label='Small select example' name=''>" + 
                            selectOptions+
                        "</select>"+
                    "</div>";
                    $(frm).insertAfter('.select-action-class:last');
                    $('.loader').hide();
            });
            
        });
        

        // Set flag ke true untuk menandakan bahwa elemen sudah ditambahkan
        isElementAdded = true;
    }
});


