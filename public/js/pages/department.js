const departmentRules = {

    department_code: {
        required: true,
        alphaNumeric: true,

        messages: {
            required: "Field is required.",
            alphaNumeric: "Only letters, numbers and spaces are allowed.",
        }
    },

    department_name: {
        required: true,
        alphabet: true,
        messages: {
            required: "Field is required.",
            alphabet: "Only letters  allowed.",
        }
    }

};

$(function () {

    $('form').on('submit', function (e) {

        let isValid = true;

        $(this).find('.form-control, .form-select').each(function () {

            if (!InlineValidator.validateField($(this), departmentRules)) {
                isValid = false;
            }

        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }

    });



    $(document).on('keyup blur change', '.form-control', function () {

        InlineValidator.validateField($(this), departmentRules);

    });

});
