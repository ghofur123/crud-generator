class TableUpdater {
    constructor(apiHandler, uiConstants) {
        this.apiHandler = apiHandler;

        this.CARD_CLASS = '.card';
        this.LOADER_CLASS = '.loader';
        this.PAGINATION_CLASS = '.pagination';
        this.TABLE_DATA_RESULT_CLASS = '.table-data-result';
    }

    updateTable(data) {
        let result = data.data;
        let links = data.links;
        let metaData = data.meta;
        let tableData = "";


        let columns = Object.keys(result[0]);

        console.log(result.length);

        tableData += '<thead>' +
            "<tr>";
        for (let i = 0; i < columns.length; i++) {
            let numberColumns = i + 1;

            if (numberColumns === columns.length) {
                tableData += '<th>Actions</th>';
            } else {
                tableData += '<th>' + columns[i] + '</th>';
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
                    tableData += '<td>' + result[i][columnName] + '</td>';
                }
            }

            tableData += '<td>' +
                '<button class="btn btn-primary btn-edit-class" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data="' + result[i].id + '">Edit</button>' +
                '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete">Delete</button>' +
                '</td>';

            tableData += '</tr>';
        }

        let buttonValue = "";
        for (let i = 0; i < metaData.last_page + 2; i++) {
            if (metaData.links[i].active === true) {
                buttonValue += '<li class="page-item active"><a class="page-link" href="#" data="' + metaData.links[i].url + '">' + metaData.links[i].label + '</a></li>';
            } else {
                buttonValue += '<li class="page-item"><a class="page-link" href="#" data="' + metaData.links[i].url + '">' + metaData.links[i].label + '</a></li>';
            }
        }

        $(this.LOADER_CLASS).hide();
        $(this.CARD_CLASS).show();
        $(this.PAGINATION_CLASS).html(buttonValue);
        $(this.TABLE_DATA_RESULT_CLASS).html(tableData);
  
    }
        
}