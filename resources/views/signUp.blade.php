<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-color-signup">
            <div>
                <p class="logo-size">LOGO</p>
            </div>
            <!-- Left side -->
            <div class="col left-side">
                <div class="login-section">
                    <h2>Sudah Punya Akun?</h2>
                    <p>Selamat datang kembali! Masuk untuk melanjutkan menggunakan aplikasi.</p>
                    <a href="" class="btn btn-custom-register">Masuk</a>
                </div>
            </div>

            <!-- Right side -->
            <div class="col right-side">
                <div class="login-section">
                    <h2>DAFTAR</h2>
                    <form action="{{ route('register') }}" class="form-signup" method="POST">
                        @csrf
                        <div class="form-group adjust-align-left">
                            <label for="Email">Email</label>
                            <div class="input-group custom-input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="iconify" data-icon="ic:sharp-email" data-width="20" data-height="16"></span></div>
                                </div>
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group adjust-align-left">
                            <label for="password">Kata Sandi</label>
                            <div class="input-group custom-input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span></div>
                                </div>
                                <input type="password" class="form-control edit-password" id="password" name="password" placeholder="Kata Sandi" required>
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
                                    <div class="input-group-text"><span class="iconify" data-icon="uis:lock" data-width="18" data-height="23"></span></div>
                                </div>
                                <input type="password" class="form-control edit-password" id="confirmPassword" name="confirmPassword" placeholder="Kata Sandi" required>
                                <div class="input-group-append">
                                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                                        <span class="iconify" data-icon="mdi:eye-off" data-width="30" data-height="20"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="error-message" style="color: red; display: none;">
                            Kata sandi tidak cocok!
                        </div>
                        <button type="submit" class="btn btn-daftar-signup">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Iconify icon -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Password matching validation
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', function(event) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const errorMessage = document.getElementById('error-message');

                if (password !== confirmPassword) {
                    event.preventDefault(); // Stop form submission
                    errorMessage.style.display = 'block'; // Show error message
                } else {
                    errorMessage.style.display = 'none'; // Hide error message
                }
            });
        });
    </script>
</body>
</html>
