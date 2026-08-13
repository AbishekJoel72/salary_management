function initializeSelect2() {
    $(".select2").select2();
}

let messages = {};

$.getJSON('/json/messages.json', function (data) {
    messages = data;
});

$(document).on('click', '.confirmSubmit', function (e) {

    e.preventDefault();

    let button = this;
    let form = $(button).closest('form');
    let messageKey = $(button).data('message');

    Swal.fire({
        title: 'Confirmation',
        text: messages[messageKey],
        width: '320px',
        padding: '1rem',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        buttonsStyling: false,
        customClass: {
            popup: 'custom-popup',
            title: 'custom-title',
            htmlContainer: 'custom-text',
            confirmButton: 'btn btn-primary custom-btn me-2',
            cancelButton: 'btn btn-secondary custom-btn'
        },
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });

});


function confirmAction(message, callback) {

    Swal.fire({
        title: 'Confirmation',
        text: message,
        width: '320px',
        padding: '1rem',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        buttonsStyling: false,
        customClass: {
            popup: 'custom-popup',
            title: 'custom-title',      // Center title
            htmlContainer: 'customs-message', // Center message
            confirmButton: 'btn btn-primary custom-btn me-2',
            cancelButton: 'btn btn-secondary custom-btn'
        },
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });

}
