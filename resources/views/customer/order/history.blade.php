<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Riwayat Pesanan - Ruang Seduh</title>
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
  .oh-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: var(--cream);
    position:relative;
    overflow-x:hidden;
  }

  .oh-title{
    text-align:center;
    font-size:24px;
    font-weight:800;
    color:var(--dark);
    padding:48px 20px 26px;
  }

  .oh-list{
    padding:0 20px 130px;
    display:flex;
    flex-direction:column;
    gap:16px;
  }

  .oh-card{
    background:#ffffff;
    border-radius:20px;
    padding:20px;
    box-shadow:0 4px 14px rgba(0,0,0,.05);
  }

  .oh-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    margin-bottom:4px;
  }
  .oh-number{
    font-size:16px;
    font-weight:800;
    color:var(--dark);
    margin-bottom:2px;
  }
  .oh-meta{
    font-size:13px;
    color:var(--muted);
  }

  .oh-badge{
    flex-shrink:0;
    font-size:12px;
    font-weight:700;
    padding:6px 14px;
    border-radius:999px;
    background:rgba(224,122,95,0.15);
    color:var(--accent);
    white-space:nowrap;
  }

  .oh-items{
    margin:16px 0 12px;
  }
  .oh-item-row{
    display:flex;
    justify-content:space-between;
    font-size:14px;
    color:#4a4540;
    padding:2px 0;
  }

  .oh-divider{
    border:none;
    border-top:1px solid #eee2d8;
    margin:14px 0;
  }

  .oh-bottom{
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .oh-total{
    font-size:17px;
    font-weight:800;
    color:var(--dark);
  }

  .oh-detail-btn{
    font-size:13px;
    font-weight:700;
    color:var(--accent);
    border:1.5px solid var(--accent);
    background:none;
    padding:8px 18px;
    border-radius:999px;
    text-decoration:none;
    cursor:pointer;
    white-space:nowrap;
  }

  .oh-empty{
    text-align:center;
    color:var(--muted);
    font-size:14px;
    padding:60px 20px;
  }

  /* Bottom Navbar shared with the home page */
  .navbar-wrap {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    padding: 0 16px 16px;
    pointer-events: none;
    z-index: 100;
  }

  .navbar {
    width: 100%;
    max-width: 440px;
    pointer-events: auto;
    display: flex;
    align-items: center;
    justify-content: space-around;
    background: #ffffff;
    border-radius: 28px;
    padding: 8px 12px;
    box-shadow: 0 12px 35px rgba(35, 22, 17, 0.18);
    border: 1px solid #ebdcd1;
  }

  .nav-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    padding: 8px 16px;
    border-radius: 18px;
    text-decoration: none;
    color: #8c7f76;
    font-size: 11px;
    font-weight: 600;
    transition: all 0.2s ease;
    min-width: 68px;
  }

  .nav-link svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
    transition: stroke 0.2s ease;
  }

  .nav-link.active {
    background: #f4ede6;
    color: #4a2c20;
    font-weight: 800;
  }

  .nav-link.active svg {
    stroke: #4a2c20;
  }

  @media (min-width:700px){
    .oh-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

@php
  $statusLabel = [
    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
    'diproses'            => 'Diproses',
    'selesai'             => 'Selesai',
    'dibatalkan'          => 'Dibatalkan',
  ];
@endphp

<div class="oh-wrap">

  <div class="oh-title">Riwayat Pesanan</div>

  <div class="oh-list">
    @forelse($orders as $order)
      @php
        $label = $statusLabel[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status));
      @endphp
      <div class="oh-card">
        <div class="oh-top">
          <div>
            <div class="oh-number">Pesanan #{{ $order->id }}</div>
            <div class="oh-meta">{{ $order->created_at->diffForHumans() }} &middot; Meja {{ $order->tabel->table_number ?? '-' }}</div>
          </div>
          <div class="oh-badge">{{ $label }}</div>
        </div>

        <div class="oh-items">
          @foreach($order->orderItems as $item)
            <div class="oh-item-row">
              <span>{{ $item->menu_name }} x{{ $item->qty }}</span>
              <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
          @endforeach
        </div>

        <hr class="oh-divider">

        <div class="oh-bottom">
          <div class="oh-total">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
          @if(Route::has('customer.order.detail'))
            <a href="{{ route('customer.order.detail', $order->id) }}" class="oh-detail-btn">Lihat Detail</a>
          @endif
        </div>
      </div>
    @empty
      <div class="oh-empty">Belum ada riwayat pesanan.</div>
    @endforelse
  </div>

  <div class="navbar-wrap">
    <nav class="navbar" id="navbar">
      <a href="{{ route('customer.home') }}" class="nav-link" aria-label="Beranda">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Beranda</span>
      </a>
      <a href="{{ route('customer.order.history') }}" class="nav-link active" aria-label="Riwayat">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span>Riwayat</span>
      </a>
      <a href="{{ route('customer.cart.index') }}" class="nav-link" aria-label="Keranjang">
        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span>Keranjang</span>
      </a>
      <a href="{{ route('customer.profile.index') }}" class="nav-link" aria-label="Profil">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Profil</span>
      </a>
    </nav>
  </div>

</div>
</body>
</html>