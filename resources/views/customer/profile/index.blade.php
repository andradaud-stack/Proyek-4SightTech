<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Profil Saya - Ruang Seduh</title>
<style>
  :root{
    --accent: #e07a5f;
    --dark: #141414;
    --muted: #8a8580;
    --cream: #f6ece3;
  }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #111;
  }
  .pf-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: linear-gradient(180deg, #241814 0%, #17110f 260px, var(--cream) 260px);
    position:relative;
    overflow-x:hidden;
  }

  .pf-header{
    padding:56px 20px 60px;
    text-align:center;
  }
  .pf-header h1{
    color:#fff;
    font-size:24px;
    font-weight:800;
    margin:0;
  }

  .pf-card{
    background:var(--cream);
    border-radius:32px 32px 0 0;
    margin-top:-40px;
    padding:32px 24px 120px;
    min-height:calc(100dvh - 220px);
  }

  .pf-alert{
    background:#fff;
    border:1px solid var(--accent);
    border-radius:12px;
    padding:12px 16px;
    font-size:13px;
    font-weight:700;
    color:#a4533f;
    margin-bottom:20px;
    text-align:center;
  }

  .pf-name{
    text-align:center;
    font-size:20px;
    font-weight:800;
    color:var(--dark);
    margin-bottom:4px;
  }
  .pf-email{
    text-align:center;
    font-size:14px;
    color:var(--muted);
    margin-bottom:36px;
  }

  .pf-menu{
    margin-bottom:36px;
  }
  .pf-item{
    display:flex;
    align-items:center;
    gap:14px;
    padding:16px 4px;
    border-bottom:1.5px solid rgba(20,20,20,0.15);
    text-decoration:none;
    color:var(--dark);
    cursor:pointer;
    background:none;
    border-left:none;
    border-right:none;
    border-top:none;
    width:100%;
    text-align:left;
    font-family:inherit;
  }
  .pf-item:last-child{
    border-bottom:1.5px solid rgba(20,20,20,0.15);
  }
  .pf-item svg{
    width:20px;
    height:20px;
    stroke:var(--dark);
    stroke-width:1.8;
    fill:none;
    flex-shrink:0;
  }
  .pf-item span{
    font-size:15px;
    font-weight:700;
    flex:1;
  }
  .pf-chevron{
    width:16px !important;
    height:16px !important;
    stroke:var(--dark) !important;
    stroke-width:2.2 !important;
    flex-shrink:0;
  }

  .pf-logout-form{ margin:0; }
  .pf-logout{
    width:100%;
    background:none;
    border:1.5px solid var(--accent);
    color:var(--accent);
    font-size:15px;
    font-weight:700;
    padding:16px 0;
    border-radius:999px;
    cursor:pointer;
  }
  .pf-logout:active{ opacity:0.8; }

  /* Bottom Navbar (fixed to real screen) */
  .navbar-wrap{
    position:fixed;
    left:0;
    right:0;
    bottom:0;
    display:flex;
    justify-content:center;
    padding:0 20px 20px;
    pointer-events:none;
  }
  .navbar{
    width:100%;
    max-width:440px;
    pointer-events:auto;
    display:flex;
    align-items:center;
    justify-content:space-around;
    background:#ffffff;
    border-radius:999px;
    padding:14px 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,.25);
  }
  .nav-item{
    background:none;
    border:none;
    padding:9px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    text-decoration:none;
  }
  .nav-item svg{
    width:22px; height:22px;
    stroke:var(--dark);
    stroke-width:1.8;
    fill:none;
  }
  .nav-item.active{
    background: var(--accent);
    box-shadow: 0 0 0 4px #ffffff, 0 4px 10px rgba(224,122,95,0.5);
  }
  .nav-item.active svg{ stroke:#ffffff; }

  @media (min-width:700px){
    .pf-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

<div class="pf-wrap">

  <div class="pf-header">
    <h1>Profil Saya</h1>
  </div>

  <div class="pf-card">
    @if(session('message_success'))
      <div class="pf-alert">{{ session('message_success') }}</div>
    @endif

    <div class="pf-name">{{ $user->name ?? 'Customer' }}</div>
    <div class="pf-email">{{ $user->email ?? '' }}</div>

    <div class="pf-menu">
      <a href="{{ Route::has('customer.order.history') ? route('customer.order.history') : '#' }}" class="pf-item">
        <svg viewBox="0 0 24 24">
          <rect x="5" y="4" width="14" height="17" rx="2"/>
          <path d="M9 2h6v3H9z"/>
          <circle cx="12" cy="14" r="3.2"/>
          <path d="M12 12.5v1.7l1.2 1"/>
        </svg>
        <span>Riwayat Pesanan</span>
        <svg class="pf-chevron" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="{{ Route::has('customer.profile.edit') ? route('customer.profile.edit') : '#' }}" class="pf-item">
        <svg viewBox="0 0 24 24">
          <path d="M12 20h9"/>
          <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
        </svg>
        <span>Ubah Profil</span>
        <svg class="pf-chevron" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      </a>

      <a href="{{ Route::has('customer.password.edit') ? route('customer.password.edit') : '#' }}" class="pf-item">
        <svg viewBox="0 0 24 24">
          <rect x="5" y="10" width="14" height="10" rx="2"/>
          <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
        </svg>
        <span>Ubah Kata Sandi</span>
        <svg class="pf-chevron" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      </a>
    </div>

    <form action="{{ route('customer.logout') }}" method="POST" class="pf-logout-form">
      @csrf
      <button type="submit" class="pf-logout">Keluar</button>
    </form>
  </div>

  <div class="navbar-wrap">
    <nav class="navbar">
      <a href="{{ route('customer.profile.index') }}" class="nav-item active" aria-label="Profil">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
      </a>
      <a href="{{ Route::has('customer.order.history') ? route('customer.order.history') : '#' }}" class="nav-item" aria-label="Riwayat">
        <svg viewBox="0 0 24 24">
          <rect x="5" y="4" width="14" height="17" rx="2"/>
          <path d="M9 2h6v3H9z"/>
          <circle cx="12" cy="14" r="3.2"/>
          <path d="M12 12.5v1.7l1.2 1"/>
        </svg>
      </a>
      <a href="{{ route('customer.home') }}" class="nav-item" aria-label="Beranda">
        <svg viewBox="0 0 24 24"><path d="M4 11 12 4l8 7"/><path d="M6 10v9h12v-9"/></svg>
      </a>
      <a href="{{ Route::has('customer.cart.index') ? route('customer.cart.index') : '#' }}" class="nav-item" aria-label="Keranjang">
        <svg viewBox="0 0 24 24">
          <path d="M4 5h2l1.5 10.5A2 2 0 0 0 9.5 17h7a2 2 0 0 0 2-1.7L20 8H6.2"/>
          <circle cx="10" cy="20" r="1.2" fill="currentColor" stroke="none"/>
          <circle cx="17" cy="20" r="1.2" fill="currentColor" stroke="none"/>
        </svg>
      </a>
      <a href="{{ Route::has('customer.notification') ? route('customer.notification') : '#' }}" class="nav-item" aria-label="Notifikasi">
        <svg viewBox="0 0 24 24">
          <path d="M6 10a6 6 0 0 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/>
          <path d="M10 19a2 2 0 0 0 4 0"/>
        </svg>
      </a>
    </nav>
  </div>

</div>
</body>
</html>