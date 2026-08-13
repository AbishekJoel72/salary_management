<!DOCTYPE html>
<html lang="en">

@include('layout.include.head')

<body>

    <div class="container login-container d-flex justify-content-center align-items-center">
        <div class="row align-items-stretch bg-white border rounded shadow w-50 overflow-hidden register-card-row">

            <div class="col-md-12 p-5 d-flex flex-column justify-content-center">
                <div class="register-form">
                    <h2 class="text-center mb-2 fw-bold">Create Account</h2>

                    <p class="text-center text-muted mb-4 register-subtitle">
                        Register as an employee
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="input-group-custom form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name"
                                required placeholder="Name" autocomplete="name">
                            <label for="name">Full Name</label>
                            <i class="bi bi-person-fill input-icon-end"></i>
                        </div>



                        <div class="input-group-custom form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                               required placeholder="Email" autocomplete="email">
                            <label for="email">Email Address</label>
                            <i class="bi bi-envelope-fill input-icon-end"></i>
                        </div>


                        <div class="input-group-custom form-floating mb-3">
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Phone" autocomplete="tel" maxlength="10">
                            <label for="phone">Phone Number</label>
                            <i class="bi bi-telephone-fill input-icon-end"></i>
                        </div>


                        <div class="input-group-custom form-floating mb-3">
                            <input type="password" class="form-control password-input" id="password" name="password"
                                required placeholder="Password" autocomplete="new-password">
                            <label for="password">Password</label>
                            <i class="bi bi-eye-slash-fill input-icon-end toggle-password"></i>
                        </div>


                        <div class="input-group-custom form-floating mb-4">
                            <input type="password" class="form-control password-input" id="password_confirmation"
                                name="password_confirmation" required placeholder="Confirm Password"
                                autocomplete="new-password">
                            <label for="password_confirmation">
                                Confirm Password
                            </label>
                            <i class="bi bi-eye-slash-fill input-icon-end toggle-password"></i>
                        </div>


                        <button type="submit" class="btn btn-custom-primary w-100">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Create Account
                        </button>

                        <div class="text-center mt-4">
                            <span class="register-text">
                                Already have an account?
                            </span>
                            <a href="{{ route('login') }}"  style="color: var(--primary-color); text-decoration: none;">
                                Login
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @include('layout.include.script')

    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const input = this.parentElement.querySelector('.password-input');
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-slash-fill');
                    this.classList.add('bi-eye-fill');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye-fill');
                    this.classList.add('bi-eye-slash-fill');
                }
            });
        });
    </script>
</body>

</html>
