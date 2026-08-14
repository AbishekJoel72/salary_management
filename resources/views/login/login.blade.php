<!DOCTYPE html>
<html lang="en">

@include('layout.include.head')

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100 ">
        <div class="row align-items-stretch bg-white border rounded shadow w-50 overflow-hidden login-card-row">
            <div class="col-md-12 p-5 d-flex flex-column justify-content-center">
                <div class="login-form">
                    <h2 class="text-center mb-4 fw-bold">Login</h2>
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="login_type" value="true">

                        <div class="input-group-custom form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" required
                                placeholder="Username | Email | Reg No" autocomplete="off">
                            <label for="username">Username | Email </label>
                            <i class="bi bi-person-fill input-icon-end"></i>
                            <small class="text-danger"></small>
                        </div>

                        <div class="input-group-custom form-floating mb-3">
                            <input type="password" class="form-control password-input" id="password" name="password"
                                required placeholder="Password" autocomplete="off">
                            <label for="password">Password</label>
                            <i class="bi bi-eye-slash-fill input-icon-end toggle-password"></i>
                            <small class="text-danger"></small>
                        </div>

                        {{-- <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember"
                                    style="font-size: 0.9rem;">Remember me</label>
                            </div>
                            <a href="#" class="forgot-link text-decoration-none" style="font-size: 0.9rem;">Forgot
                                Password?</a>
                        </div> --}}

                        <button type="submit" class="btn btn-custom-primary w-100">Login</button>

                        {{-- <div class="text-center mt-4">
                            <span class="register-text">Don't have an account?</span>
                            <a href="{{ route('register') }}"  style="color: var(--primary-color); text-decoration: none;">
                                Register Now
                            </a>
                        </div> --}}
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
