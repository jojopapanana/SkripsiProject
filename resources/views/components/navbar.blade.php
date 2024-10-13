<div class="container ms-0" id="navbar-container">
    <table id="navbar-container">
        <tr>
            <td valign="top" class="pt-5"><a href="{{ route('Dashboard') }}">LOGO</a></td>
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
        <tr>
            <td valign="bottom">
                <div class="d-flex gap-3 pb-5 profile-bottom" id="profile" style="color: white">
                <i class="bi bi-person-circle"></i>
                <a href="{{ route('register') }}" class="p-0 m-0">Profil</a>
                </div>
            </td>
        </tr>
    </table>
</div>
