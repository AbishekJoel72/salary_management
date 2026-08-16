const designationRules = {

    department: {
        required: true,
        messages: {
            required: "Please select the Field."
        }
    },

    designation_name: {
        required: true,
        alphabet: true,
        messages: {
            required: "Field is required.",
            alphabet: "Only letters and spaces are allowed.",
        }
    }

};

$(function () {

    $('form').on('submit', function (e) {

        let isValid = true;

        $(this).find('.form-control, .form-select').each(function () {

            if (!InlineValidator.validateField($(this), designationRules)) {
                isValid = false;
            }

        });

        if (!isValid) {
            e.preventDefault();
            return false;
        }

    });



    $(document).on('keyup blur change','.form-control, .form-select',function () {

        InlineValidator.validateField($(this), designationRules);

    });

});
