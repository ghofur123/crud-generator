function setValues(data) {
    $.each(data, function(key, value) {
        $('input[name="' + key + '"]').val(value);
    });
}
function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
function loadContentMenu(divClass, url, callback){
    callback(data);
    $(divClass).load(url);
}
