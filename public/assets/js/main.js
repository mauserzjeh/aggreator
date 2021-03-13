$(() => {
    $.validator.setDefaults({
        errorElement: 'div',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback form-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass('is-invalid');
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).removeClass('is-invalid');
        }
    });

    $.validator.addMethod('pair', (value, element, param) => {
        let otherElement = $(param);
        if(value != '') {
            if(otherElement.val() != '') {
                return true;
            }
            return false;
        }
        return true;
    });
});

