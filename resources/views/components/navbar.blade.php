<div class="container ms-0" id="navbar-container">
    <table id="navbar-container">
        <tr>
            <td valign="top" class="pt-5"><a href="{{ route('Dashboard') }}"><img src="/assets/logo skripsi1.PNG" alt="LOGO" style="width: 10vw"></a></td>
        </tr>
        <tr class="{{ Route::is('transaksi') ? 'active-row' : '' }}">
            <td><a href="{{ route('transaksi') }}" style="text-decoration: none">Transaksi</a></td>
        </tr>
        <tr class="{{ Route::is('aruskas') ? 'active-row' : '' }}">
            <td><a href="{{ route('aruskas') }}">Arus Kas</a></td>
        </tr>
        <tr class="{{ Route::is('labarugi') ? 'active-row' : '' }}">
            <td><a href="{{ route('labarugi') }}">Laba Rugi</a></td>
        </tr>
        <tr class="{{ Route::is('stok') ? 'active-row' : '' }}">
            <td><a href="{{ route('stok') }}">Stok Barang</a></td>
        </tr>
        <tr class="{{ Route::is('analisisTrend') ? 'active-row' : '' }}">
            <td><a href="{{ route('analisisTrend') }}">Analisis Tren</a></td>
        </tr>
        <tr class="{{ Route::is('utangPiutang') ? 'active-row' : '' }}">
            <td><a href="{{ route('utangPiutang') }}">Utang Piutang</a></td>
        </tr>
        <tr class="{{ Route::is('reminder') ? 'active-row' : '' }}">
            <td><a href="{{ route('reminder') }}">Pengingat</a></td>
        </tr>
        <tr>
            <td valign="bottom">
                <div class="d-flex gap-3 pb-5 profile-bottom" id="profile" style="color: white">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#logoutModal" class="btn p-0 me-5 selected-part" style="color: white; border: none; margin-left: 1px">
                        <div class="d-flex gap-3 fs-5">
                            <i class="bi bi-box-arrow-right"></i>
                            <a class="p-0 m-0" href="#">
                                Keluar
                            </a>
                        </div>
                    </button>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <center>
                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                </center>

                <h4 class="fw-bold text-center">Apakah Anda yakin ingin keluar?</h4>

                <div class="d-flex justify-content-center gap-4 mt-4">
                    <button class="btn fw-semibold cancel-btn" data-bs-dismiss="modal">Tidak</button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        <button class="btn fw-semibold confirm-btn">Ya</button>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
