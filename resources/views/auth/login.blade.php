<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MASUK</title>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/dark icon.png">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div>
        <img src="/assets/dark icon.png" alt="LOGO" class="icon-size">
    </div>

    <div class="container-fluid class-appear-below-1204">
        <div class="row" id="auth-section">
            <!-- content changeable using JS-->
        </div>
    </div>

    <div class="container-fluid class-appear-up-1204">
        <div class="row bg-color-signup">
            <div id="main" class="{{ session('form_type') != 'login' ? 'right-panel-active' : '' }}">
                <!-- Left side -->
                <div class="col left-side transitionClassSignIn p-5">
                    <div class="login-section">
                        <h2>MASUK</h2>
    
                        @if ($errors->any() && session('form_type') === 'login')
                            <div class="error-messages text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    
                        <form action="{{ route('login.auth') }}" class="form-signup" method="POST">
                            @csrf
                            <div class="form-group adjust-align-left">
                                <label for="Email">Email</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="ic:sharp-email" data-width="20" data-height="16"></span>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="form-control @if($errors->has('email') && session('form_type') === 'login') is-invalid @endif" id="Email" placeholder="Email" value="{{ session('email') }}" required>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="password">Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password @if($errors->has('password') && session('form_type') === 'login') is-invalid @endif" id="password" name="password" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password-default" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-daftar-signup">Masuk</button>
                        </form>
                    </div>
                </div>
    
                <!-- Right side -->
                <div class="col right-side transitionClassSignUp">
                    <div class="login-section">
                        <h2>DAFTAR</h2>
    
                        @if ($errors->any() && session('form_type') != 'login')
                            <div class="error-messages text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    
                        <form action="{{ route('register') }}" class="form-signup" method="POST">
                            @csrf
                            <div class="form-group adjust-align-left">
                                <label for="Email">Email</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="ic:sharp-email" data-width="20" data-height="16"></span>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="form-control @if($errors->has('email') && session('form_type') != 'login') is-invalid @endif" id="Email" placeholder="Email" value="{{ session('form_type') != 'login' ? old('email') : '' }}" required>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="password">Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password @if($errors->has('password') && session('form_type') != 'login') is-invalid @endif" id="password" name="password" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password-default" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password" id="password_confirmation" name="password_confirmation" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password-default" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-daftar-signup">Daftar</button>
                        </form>
                    </div>
                </div>
    
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-left">
                            <div class="login-section">
                                <h2>Sudah Punya Akun?</h2>
                                <p>Selamat datang kembali! Masuk untuk melanjutkan menggunakan aplikasi.</p>
                                <a href="#" class="btn btn-custom-register" id="signInYey">Masuk</a>
                            </div>
                        </div>
                        <div class="overlay-right">
                            <div class="login-section">
                                <h2>Belum Punya Akun?</h2>
                                <p>Daftarkan akunmu sekarang juga untuk menggunakan aplikasi kami!</p>
                                <a href="#" class="btn btn-custom-register" id="signUpYey">Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>

    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainSection = document.getElementById('main');
            const authSection = document.getElementById('auth-section');

            let isBelow823 = window.innerWidth > 823;

            function updateFormLayout() {
                const screenWidth = window.innerWidth;

                if (screenWidth < 823 && !isBelow823) {
                    isBelow823 = true;

                    if (!mainSection.classList.contains('right-panel-active')) {
                        switchToLogin();
                    } else {
                        switchToRegister();
                    }
                } else if (screenWidth >= 823 && isBelow823) {
                    isBelow823 = false;
                }
            }

            // Listen for window resize events
            window.addEventListener('resize', updateFormLayout);

            // Initial call to set the correct layout
            updateFormLayout();
        });

        function switchToRegister() {
            const mainSection = document.getElementById('main');
            const authSection = document.getElementById('auth-section');

            // add the right-panel-active class from mainSection
            mainSection.classList.add('right-panel-active');

            document.getElementById('auth-section').innerHTML = `
                <div class="col below-1204" style="background-color: #ffffff">
                    <div class="login-section">
                        <h2>DAFTAR</h2>

                        @if ($errors->any() && session('form_type') != 'login')
                            <div class="error-messages text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" class="form-signup" method="POST">
                            @csrf
                            <div class="form-group adjust-align-left" style="margin-top: 3.125rem">
                                <label for="Email">Email</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="ic:sharp-email" data-width="20" data-height="16"></span>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="form-control @if($errors->has('email') && session('form_type') != 'login') is-invalid @endif" id="Email" placeholder="Email" value="{{ session('form_type') != 'login' ? old('email') : '' }}" required>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="password">Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password @if($errors->has('password') && session('form_type') != 'login') is-invalid @endif" id="password" name="password" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="confirmPassword">Konfirmasi Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password" id="password_confirmation" name="password_confirmation" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-daftar-signup">Daftar</button>
                        </form>

                        <p class="signup-prompt pb-5" style="font-size: 1.2rem">
                            Sudah punya akun? <a href="#" onclick="switchToLogin()">Masuk</a>
                        </p>
                    </div>
                </div>
            `;

            attachTogglePasswordListeners();
        }

        function switchToLogin() {
            const mainSection = document.getElementById('main');
            const authSection = document.getElementById('auth-section');

            // Remove the right-panel-active class from mainSection
            mainSection.classList.remove('right-panel-active');

            document.getElementById('auth-section').innerHTML = `
                <div class="col below-1204" style="background-color: #ffffff">
                    <div class="login-section">
                        <h2>MASUK</h2>

                        @if ($errors->any() && session('form_type') === 'login')
                            <div class="error-messages text-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login.auth') }}" class="form-signup" method="POST">
                            @csrf
                            <div class="form-group adjust-align-left" style="margin-top: 3.125rem">
                                <label for="Email">Email</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="ic:sharp-email" data-width="20" data-height="16"></span>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="form-control @if($errors->has('email') && session('form_type') === 'login') is-invalid @endif" id="Email" placeholder="Email" value="{{ session('email') }}" required>
                                </div>
                            </div>
                            <div class="form-group adjust-align-left">
                                <label for="password">Kata Sandi</label>
                                <div class="input-group custom-input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control edit-password @if($errors->has('password') && session('form_type') === 'login') is-invalid @endif" id="password" name="password" placeholder="Kata Sandi" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-daftar-signup">Masuk</button>
                        </form>

                        <p class="signup-prompt pb-5" style="font-size: 1.2rem">
                            Belum punya akun? <a href="#" onclick="switchToRegister()">Daftar</a>
                        </p>
                    </div>
                </div>
            `;

            attachTogglePasswordListeners();
        }
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainElement = document.getElementById('main');
            if (!mainElement.classList.contains('right-panel-active')) {
                mainElement.classList.remove('right-panel-active');
            }
        });
    </script> --}}

    <script>
        const signUpButton = document.getElementById('signUpYey');
        const signInButton = document.getElementById('signInYey');
        const main = document.getElementById('main');

        signUpButton.addEventListener('click', () => {
            main.classList.add("right-panel-active");
        });
        signInButton.addEventListener('click', () => {
            main.classList.remove("right-panel-active");
        });
    </script>

    <script>
        function attachTogglePasswordListeners() {
            const togglePassword = document.querySelectorAll('.toggle-password');
            togglePassword.forEach(function(item) {
                item.addEventListener('click', function() {
                    const passwordInput = this.closest('.input-group').querySelector('input');
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    const icon = this.querySelector('.iconify');
                    if (type === 'password') {
                        icon.setAttribute('data-icon', 'mdi:eye-off');
                    } else {
                        icon.setAttribute('data-icon', 'mdi:eye');
                    }
                });
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelectorAll('.toggle-password-default');
            togglePassword.forEach(function(item) {
                item.addEventListener('click', function() {
                    const passwordInput = this.closest('.input-group').querySelector('input');
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    const icon = this.querySelector('.iconify');
                    if (type === 'password') {
                        icon.setAttribute('data-icon', 'mdi:eye-off');
                    } else {
                        icon.setAttribute('data-icon', 'mdi:eye');
                    }
                });
            });

            const form = document.getElementById('registerForm');
            form.addEventListener('submit', function(event) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const errorMessage = document.getElementById('error-message');

                if (password !== confirmPassword) {
                    event.preventDefault();
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>