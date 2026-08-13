const InlineValidator = {

    // Full Form Validation (Submit)
    validate(formSelector, rules) {

        let isValid = true;

        $.each(rules, function (field, rule) {

            let input = $(formSelector).find('[name="' + field + '"]');

            if (!InlineValidator.validateField(input, rules)) {
                isValid = false;
            }

        });

        return isValid;
    },

    // Single Field Validation (Typing)
    validateField(input, rules) {

        let field = input.attr('name');

        let rule = rules[field];

        if (!rule) {
            return true;
        }

        let value = $.trim(input.val());

        // Clear
        input.removeClass('is-valid is-invalid');
        input.closest('.form-field').find('.text-errors').text('');

        // Required
        if (rule.required && value === "") {
            this.error(input, rule.messages.required);
            return false;
        }

        // Minimum Length
        if (rule.min && value.length < rule.min) {
            this.error(input, rule.messages.min);
            return false;
        }

        // Maximum Length
        if (rule.max && value.length > rule.max) {
            this.error(input, rule.messages.max);
            return false;
        }

        // Email
        if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            this.error(input, rule.messages.email);
            return false;
        }

        // Phone
        if (rule.phone && !/^[6-9]\d{9}$/.test(value)) {
            this.error(input, rule.messages.phone);
            return false;
        }

        // Number
        if (rule.number && !/^\d+$/.test(value)) {
            this.error(input, rule.messages.number);
            return false;
        }

        // Decimal
        if (rule.decimal && !/^\d+(\.\d{1,2})?$/.test(value)) {
            this.error(input, rule.messages.decimal);
            return false;
        }

        // Alphabet
        if (rule.alphabet && !/^[A-Za-z ]+$/.test(value)) {
            this.error(input, rule.messages.alphabet);
            return false;
        }

        // Alpha Numeric (Special characters not allowed, Space allowed)
        if (rule.alphaNumeric && !/^[A-Za-z0-9 ]+$/.test(value)) {
            this.error(input, rule.messages.alphaNumeric);
            return false;
        }
        // Username
        if (rule.username && !/^[A-Za-z][A-Za-z0-9_]{3,20}$/.test(value)) {
            this.error(input, rule.messages.username);
            return false;
        }

        // Password
        if (rule.password &&
            !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?#&]).{8,}$/.test(value)) {
            this.error(input, rule.messages.password);
            return false;
        }

        // Success
        input.addClass('is-valid');
        return true;
    },

    error(input, message) {

        input.removeClass('is-valid')
            .addClass('is-invalid');

        input.closest('.form-field')
            .find('.text-errors')
            .text(message);
    }

};
