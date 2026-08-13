function initializeValidation() {
    const forms = document.querySelectorAll(".needs-validation");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            if ($(form).data('custom-validation')) {
                return;
            }
            e.preventDefault();
            form.classList.add("was-validated");

            if (!form.checkValidity()) {
                return;
            }

            form.submit();

        });

    });

}
