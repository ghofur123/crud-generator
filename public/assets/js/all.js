class ApiHandler {
  constructor(apiUrl) {
    this.apiUrl = apiUrl;
  }

  getData(method, data, callback) {
    // Implement your logic to fetch data from the API using method and data
    // Call the callback function with the result
  }
}

class FormHandler {
  constructor(formClass, buttonLoaderClass, buttonSubmitClass, alertWarningClass) {
    this.formClass = formClass;
    this.buttonLoaderClass = buttonLoaderClass;
    this.buttonSubmitClass = buttonSubmitClass;
    this.alertWarningClass = alertWarningClass;
  }

  handleSubmit() {
    // Implement your logic to handle form submission
  }
}

class SearchHandler {
  constructor(searchInputClass, btnSearchClass, searchFormClass, loaderClass) {
    this.searchInputClass = searchInputClass;
    this.btnSearchClass = btnSearchClass;
    this.searchFormClass = searchFormClass;
    this.loaderClass = loaderClass;
  }

  handleSearch() {
    // Implement your logic to handle search
  }
}

class PaginationHandler {
  constructor(pageLinkClass, paginationClass, tableDataResultClass) {
    this.pageLinkClass = pageLinkClass;
    this.paginationClass = paginationClass;
    this.tableDataResultClass = tableDataResultClass;
  }

  handlePagination() {
    // Implement your logic to handle pagination
  }
}

class MenuHandler {
  constructor(navLinkClass, loaderClass, urlApiSetting) {
    this.navLinkClass = navLinkClass;
    this.loaderClass = loaderClass;
    this.urlApiSetting = urlApiSetting;
  }

  init() {
    this.loadMenuData();
  }

  loadMenuData() {
    // Implement your logic to load menu data
  }

  processDefaultData(url) {
    // Implement your logic to process default data
  }
}

// Constants for class names
const CARD_CLASS = '.card';
const LOADER_CLASS = '.loader';
const EDIT_BUTTON_CLASS = '.btn-edit-class';
const FORM_CLASS = '.form-input-create';
const SEARCH_INPUT_CLASS = '.search-input-form';
const SEARCH_FORM_CLASS = '.search-table';
const PAGE_LINK_CLASS = '.page-link';
const MODAL_CONTENT_CLASS = '.modal-content-class';
const ALERT_WARNING_CLASS = '.alert-warning';
const BUTTON_LOADER_CLASS = '.button-loader-class';
const BUTTON_SUBMIT_CLASS = '.button-submit-class';
const BTN_SEARCH_CLASS = '.btn-search';
const PAGINATION_CLASS = '.pagination';
const TABLE_DATA_RESULT_CLASS = '.table-data-result';
const URL_API_SETTING = 'api/setting/json-data';

// Hide card and loader initially
$(CARD_CLASS).css('display', 'none');
$(LOADER_CLASS).hide();

// ...

// Usage

const apiHandler = new ApiHandler('api/setting/json-data');
const formHandler = new FormHandler('.form-input-create', '.button-loader-class', '.button-submit-class', '.alert-warning');
const searchHandler = new SearchHandler('.search-input-form', '.btn-search', '.search-table', '.loader');
const paginationHandler = new PaginationHandler('.page-link', '.pagination', '.table-data-result');
const menuHandler = new MenuHandler('.nav-link', '.loader', 'api/setting/json-data');

// Set up event listeners
$(document).on('submit', formHandler.formClass, function (event) {
  event.preventDefault();
  formHandler.handleSubmit();
});

$(document).on('keyup', searchHandler.searchInputClass, function () {
  searchHandler.handleSearch();
});

$(document).on('submit', searchHandler.searchFormClass, function (event) {
  event.preventDefault();
  searchHandler.handleSearch();
});

$(document).on('click', paginationHandler.pageLinkClass, function () {
  paginationHandler.handlePagination();
});

$(document).on('click', menuHandler.navLinkClass, function () {
  menuHandler.loadMenuData();
});

$(document).on('DOMContentLoaded', function () {
  menuHandler.init();
});
