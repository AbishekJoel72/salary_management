const employeeRules = {

    department_id: {
        required: true,
        messages: {
            required: "Please select Department."
        }
    },

    designation_id: {
        required: true,
        messages: {
            required: "Please select Designation."
        }
    },

    employee_code: {
        required: true,
        alphaNumeric: true,

        messages: {
            required: "Employee Code is required.",
            alphaNumeric: "Only letters, numbers and spaces are allowed.",
        }
    },

    name: {
        required: true,
        alphabet: true,
        messages: {
            required: "Employee Name is required.",
            alphabet: "Only letters and spaces are allowed.",
        }
    },

    email: {
        required: true,
        email: true,
        messages: {
            required: "Email is required.",
            email: "Please enter a valid email address.",
        }
    },

    phone: {
        required: true,
        phone: true,
        messages: {
            required: "Phone number is required.",
            phone: "Please enter a valid 10-digit phone number."
        }
    },

    joining_date: {
        required: true,
        messages: {
            required: "Joining Date is required."
        }
    },

    daily_rate: {
        decimal: true,
        messages: {
            decimal: "Please enter a valid daily rate."
        }
    },

    monthly_salary: {
        decimal: true,
        messages: {
            decimal: "Please enter a valid monthly salary."
        }
    }

};
$(function () {

    $('#Addmodel form, #Editmodel form').on('submit', function (e) {

        let form = $(this);
        let isValid = true;


        form.find('.form-control, .form-select').each(function () {

            let field = $(this).attr('name');

            if (employeeRules[field]) {

                if (!InlineValidator.validateField(
                    $(this),
                    employeeRules
                )) {
                    isValid = false;
                }

            }

        });



        let employeeType = form
            .find('input[name="employee_type"]:checked')
            .val();

        let employeeTypeField = form
            .find('input[name="employee_type"]')
            .first()
            .closest('.form-field');

        employeeTypeField
            .find('.text-errors')
            .text('');

        if (!employeeType) {

            employeeTypeField
                .find('.text-errors')
                .text('Please select Employee Type.');

            isValid = false;
        }


        if (employeeType === 'daily') {

            let dailyRate = form.find('[name="daily_rate"]');
            let value = $.trim(dailyRate.val());

            dailyRate
                .removeClass('is-valid is-invalid');

            dailyRate
                .closest('.form-field')
                .find('.text-errors')
                .text('');

            if (value === '') {

                InlineValidator.error(
                    dailyRate,
                    'Daily Rate is required.'
                );

                isValid = false;

            } else if (!/^\d+(\.\d{1,2})?$/.test(value)) {

                InlineValidator.error(
                    dailyRate,
                    'Please enter a valid daily rate.'
                );

                isValid = false;

            } else {

                dailyRate.addClass('is-valid');
            }
        }


        if (employeeType === 'monthly') {

            let monthlySalary = form.find('[name="monthly_salary"]');
            let value = $.trim(monthlySalary.val());

            monthlySalary
                .removeClass('is-valid is-invalid');

            monthlySalary
                .closest('.form-field')
                .find('.text-errors')
                .text('');

            if (value === '') {

                InlineValidator.error(
                    monthlySalary,
                    'Monthly Salary is required.'
                );

                isValid = false;

            } else if (!/^\d+(\.\d{1,2})?$/.test(value)) {

                InlineValidator.error(
                    monthlySalary,
                    'Please enter a valid monthly salary.'
                );

                isValid = false;

            } else {

                monthlySalary.addClass('is-valid');
            }
        }



        if (!isValid) {
            e.preventDefault();
            return false;
        }

    });



    $(document).on(
        'keyup blur change',
        '#Addmodel .form-control, #Addmodel .form-select, ' +
        '#Editmodel .form-control, #Editmodel .form-select',
        function () {

            let field = $(this).attr('name');

            if (employeeRules[field]) {

                InlineValidator.validateField(
                    $(this),
                    employeeRules
                );

            }

        }
    );



    $(document).on(
        'change',
        '#Addmodel input[name="employee_type"], ' +
        '#Editmodel input[name="employee_type"]',
        function () {

            let form = $(this).closest('form');
            let employeeType = $(this).val();


            if (employeeType === 'daily') {

                form.find('[id$="_daily_rate_field"]').show();
                form.find('[id$="_monthly_salary_field"]').hide();

                form.find('[name="monthly_salary"]')
                    .val('')
                    .removeClass('is-valid is-invalid');

                form.find('[name="monthly_salary"]')
                    .closest('.form-field')
                    .find('.text-errors')
                    .text('');
            }




            if (employeeType === 'monthly') {

                form.find('[id$="_daily_rate_field"]').hide();
                form.find('[id$="_monthly_salary_field"]').show();

                form.find('[name="daily_rate"]')
                    .val('')
                    .removeClass('is-valid is-invalid');

                form.find('[name="daily_rate"]')
                    .closest('.form-field')
                    .find('.text-errors')
                    .text('');
            }

        }
    );


    $('#Addmodel form, #Editmodel form').each(function () {

        let form = $(this);

        let employeeType = form
            .find('input[name="employee_type"]:checked')
            .val();

        if (employeeType === 'daily') {

            form.find('[id$="_daily_rate_field"]').show();
            form.find('[id$="_monthly_salary_field"]').hide();

        } else if (employeeType === 'monthly') {

            form.find('[id$="_daily_rate_field"]').hide();
            form.find('[id$="_monthly_salary_field"]').show();

        }

    });

});
