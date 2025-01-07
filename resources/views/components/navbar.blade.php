<ul class="nav flex-column d-flex" id="navbar-container">
    <li class="nav-item">
        <a href="{{ route('Dashboard') }}" class="nav-link styling-nav">
            <img src="/assets/logo skripsi1.PNG" class="navbar-app-logo disabled-on-shrink" alt="LOGO">
            <i class="bi bi-house-door on-shrink"></i>
        </a>
    </li>

    <div class="middle-section">
        <li class="nav-item {{ Route::is('transaksi') ? 'active-row' : '' }}">
            <a href="{{ route('transaksi') }}" class="nav-link styling-nav">
                <i class="bi bi-receipt"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Transaksi</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('aruskas') ? 'active-row' : '' }}">
            <a href="{{ route('aruskas') }}" class="nav-link styling-nav">
                <i class="bi bi-cash-coin"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Arus Kas</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('labarugi') ? 'active-row' : '' }}">
            <a href="{{ route('labarugi') }}" class="nav-link styling-nav">
                <i class="bi bi-arrow-down-up"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Laba Rugi</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('stok') ? 'active-row' : '' }}">
            <a href="{{ route('stok') }}" class="nav-link styling-nav">
                <i class="bi bi-box2"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Stok Barang</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('analisisTrend') ? 'active-row' : '' }}">
            <a href="{{ route('analisisTrend') }}" class="nav-link styling-nav">
                <i class="bi bi-graph-up"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Analisis Tren</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('utangPiutang') ? 'active-row' : '' }}">
            <a href="{{ route('utangPiutang') }}" class="nav-link styling-nav">
                <i class="bi bi-cash-stack"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Utang Piutang</span>
            </a>
        </li>
        <li class="nav-item {{ Route::is('reminder') ? 'active-row' : '' }}">
            <a href="{{ route('reminder') }}" class="nav-link styling-nav">
                <i class="bi bi-calendar-event"></i>
                <span class="disabled-on-shrink">&nbsp;&nbsp;Pengingat</span>
            </a>
        </li>
    </div>
    
    <div class="d-flex gap-3 pb-5 profile-bottom" id="profile" style="color: white">
        <button type="button" data-bs-toggle="modal" data-bs-target="#logoutModal" class="btn p-0 selected-part" style="color: white; border: none;">
            <div class="d-flex" style="font-size: 1.3rem">
                <i class="bi bi-box-arrow-right"></i>
                <a class="p-0 m-0 disabled-on-shrink" href="#">
                    &nbsp;&nbsp;&nbsp;Keluar
                </a>
            </div>
        </button>
    </div>
</ul>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body ps-4 pe-4 pb-4">
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
