const attendanceRules = {

    employee_id: {
        required: true,
        messages: {
            required: "Please select Employee."
        }
    },

    attendance_date: {
        required: true,
        messages: {
            required: "Attendance Date is required."
        }
    },

    status: {
        required: true,
        messages: {
            required: "Please select Attendance Status."
        }
    },

    check_in: {
        required: true,
        messages: {
            required: "Check In time is required."
        }
    },

    check_out: {
        required: true,
        messages: {
            required: "Check Out time is required."
        }
    },

    remarks: {
        max: 255,
        messages: {
            max: "Maximum 255 characters allowed."
        }
    }

};

$(function () {


    $('#Addmodel form, #Editmodel form').on('submit', function (e) {

        let form = $(this);
        let isValid = true;



        form.find('.form-control, .form-select').each(function () {

            let field = $(this).attr('name');

            if (attendanceRules[field]) {

                if (!InlineValidator.validateField(
                    $(this),
                    attendanceRules
                )) {
                    isValid = false;
                }

            }

        });




        let status = form
            .find('[name="status"]')
            .val();

        let checkIn = form.find('[name="check_in"]');
        let checkOut = form.find('[name="check_out"]');




        if (status === 'present') {

            if ($.trim(checkIn.val()) === '') {

                InlineValidator.error(
                    checkIn,
                    'Check In time is required.'
                );

                isValid = false;

            }

            if ($.trim(checkOut.val()) === '') {

                InlineValidator.error(
                    checkOut,
                    'Check Out time is required.'
                );

                isValid = false;

            }

        }



        if (status === 'half_day') {

            if ($.trim(checkIn.val()) === '') {

                InlineValidator.error(
                    checkIn,
                    'Check In time is required.'
                );

                isValid = false;

            }

            if ($.trim(checkOut.val()) === '') {

                InlineValidator.error(
                    checkOut,
                    'Check Out time is required.'
                );

                isValid = false;

            }

        }



        if (status === 'absent' || status === 'leave') {

            checkIn
                .removeClass('is-valid is-invalid')
                .val('');

            checkOut
                .removeClass('is-valid is-invalid')
                .val('');

            checkIn
                .closest('.form-field')
                .find('.text-errors')
                .text('');

            checkOut
                .closest('.form-field')
                .find('.text-errors')
                .text('');

        }



        let timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;

        if ($.trim(checkIn.val()) !== '') {

            if (!timePattern.test($.trim(checkIn.val()))) {

                InlineValidator.error(
                    checkIn,
                    'Please enter a valid time (HH:MM).'
                );

                isValid = false;

            }

        }

        if ($.trim(checkOut.val()) !== '') {

            if (!timePattern.test($.trim(checkOut.val()))) {

                InlineValidator.error(
                    checkOut,
                    'Please enter a valid time (HH:MM).'
                );

                isValid = false;

            }

        }



        if (
            $.trim(checkIn.val()) !== '' &&
            $.trim(checkOut.val()) !== '' &&
            timePattern.test($.trim(checkIn.val())) &&
            timePattern.test($.trim(checkOut.val()))
        ) {

            let checkInTime = checkIn.val().split(':');
            let checkOutTime = checkOut.val().split(':');

            let inMinutes =
                parseInt(checkInTime[0]) * 60 +
                parseInt(checkInTime[1]);

            let outMinutes =
                parseInt(checkOutTime[0]) * 60 +
                parseInt(checkOutTime[1]);

            if (outMinutes <= inMinutes) {

                InlineValidator.error(
                    checkOut,
                    'Check Out must be later than Check In.'
                );

                isValid = false;
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

            if (attendanceRules[field]) {

                InlineValidator.validateField(
                    $(this),
                    attendanceRules
                );

            }

        }
    );



    $(document).on(
        'change',
        '#Addmodel [name="status"], #Editmodel [name="status"]',
        function () {

            let form = $(this).closest('form');

            let status = $(this).val();

            let checkInField = form.find('[name="check_in"]');
            let checkOutField = form.find('[name="check_out"]');


            if (
                status === 'present' ||
                status === 'half_day'
            ) {

                form.find('[id$="_check_in_field"]').show();
                form.find('[id$="_check_out_field"]').show();

            }



            if (
                status === 'absent' ||
                status === 'leave'
            ) {

                form.find('[id$="_check_in_field"]').hide();
                form.find('[id$="_check_out_field"]').hide();

                checkInField
                    .val('')
                    .removeClass('is-valid is-invalid');

                checkOutField
                    .val('')
                    .removeClass('is-valid is-invalid');

                checkInField
                    .closest('.form-field')
                    .find('.text-errors')
                    .text('');

                checkOutField
                    .closest('.form-field')
                    .find('.text-errors')
                    .text('');

            }

        }
    );



    $('#Addmodel form, #Editmodel form').each(function () {

        let form = $(this);

        let status = form
            .find('[name="status"]')
            .val();

        if (
            status === 'present' ||
            status === 'half_day'
        ) {

            form.find('[id$="_check_in_field"]').show();
            form.find('[id$="_check_out_field"]').show();

        } else if (
            status === 'absent' ||
            status === 'leave'
        ) {

            form.find('[id$="_check_in_field"]').hide();
            form.find('[id$="_check_out_field"]').hide();

        }

    });

});
