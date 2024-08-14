<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav-bar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/master.css')}}" />
    <script src="https://kit.fontawesome.com/4dad1e0fea.js" crossorigin="anonymous"></script>
    <title>@yield('title')</title>
</head>
<body>
    {{-- header --}}
    <header>
      <nav>
        <table>
          <tr>
            <td>Transaksi</td>
          </tr>
          <tr>
            <td>Arus Kas</td>
          </tr>
          <tr>
            <td>Stok Barang</td>
          </tr>
          <tr>
            <td>Analisis Tren</td>
          </tr>
          <tr>
            <td>Laba Rugi</td>
          </tr>
        </table>
        <div class="profile">
          <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-user fa-stack-1x"></i>
          </span>
          <h4 class="profileText">Profil</h4>
        </div>
      </nav>
    </header>

    @yield('content')

    {{-- footer  --}}
    
</body>
</html>