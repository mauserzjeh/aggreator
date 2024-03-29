$(() => {
    $.validator.setDefaults({
        errorClass: 'is-invalid',
        errorElement: 'div',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback form-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass(errorClass);
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).removeClass(errorClass);
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

    $.validator.addMethod('greater_date', (value, element, param) => {
        let date = new Date(value);
        let other_date = new Date($(param).val());

        if (/Invalid/.test(date)) {
            return true;
        }

        if (/Invalid/.test(other_date)) {
            return true;
        }

        return date > other_date;
    });

    $('button.delete-button').on('click', function() {
        if($('#delete-modal').length) {
            $('#delete-submit-button').attr('href', $(this).data('href'))
        }
    });
});

