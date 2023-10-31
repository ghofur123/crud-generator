$(document).on('DOMContentLoaded', function () {});
$(document).on('click', '.pages-target', function () {
    let target = $(this).attr('data');
    $('.loader').show();
    $('.content-pages').load(target, function () {
        $('.loader').hide();
    });
});

$(document).on('click', '.btn-modal-create', function(event) {
    event.preventDefault();
    $('.loader').show();
    let createPages = $(this).attr('data');
    $('.modal-content-load').load(createPages, function(){
        $('.loader').hide();
    });
});



$(document).on('submit', '.form-create', function(event) {
    event.preventDefault();
    /* Act on the event */

    let linkVar = $(this).attr('action');
    let methodVar = $(this).attr('method');

    console.log(linkVar + methodVar);
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: methodVar,
        url: linkVar,
        data: $(this).serialize(),
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (data) {
            $('.loader').hide();
            
        }
    }).done(function () {});
    return false;
});
