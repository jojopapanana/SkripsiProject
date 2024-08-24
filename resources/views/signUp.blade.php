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
                                <input type="password" class="form-control " id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-daftar-signup">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Iconify icon -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</body>
</html>
