$(() => {
    $.validator.setDefaults({
        errorElement: 'div',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback form-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass('is-valid');
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).removeClass('is-valid');
        }
    });
});

