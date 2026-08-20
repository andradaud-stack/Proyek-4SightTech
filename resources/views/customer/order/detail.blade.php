<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Detail Pesanan - Ruang Seduh</title>
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
  .od-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: var(--cream);
    position:relative;
    overflow-x:hidden;
  }

  .od-header{
    display:flex;
    align-items:center;
    gap:16px;
    padding:44px 20px 28px;
  }
  .od-back{
    width:38px;
    height:38px;
    border-radius:50%;
    background:#ece0d2;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:var(--dark);
    flex-shrink:0;
  }
  .od-back svg{ width:16px; height:16px; stroke:currentColor; stroke-width:2.4; fill:none; }
  .od-header h1{
    color:var(--dark);
    font-size:22px;
    font-weight:800;
  }

  .od-body{
    padding:0 20px 60px;
    display:flex;
    flex-direction:column;
    gap:16px;
  }

  .od-info-card{
    background:#ffffff;
    border-radius:20px;
    padding:20px;
    box-shadow:0 4px 14px rgba(0,0,0,.04);
  }
  .od-info-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:6px 0;
  }
  .od-info-label{
    font-size:14px;
    color:var(--muted);
  }
  .od-info-value{
    font-size:14px;
    font-weight:700;
    color:var(--dark);
  }

  .od-status-badge{
    align-self:flex-start;
    font-size:12px;
    font-weight:700;
    padding:6px 14px;
    border-radius:999px;
    background:rgba(224,122,95,0.15);
    color:var(--accent);
  }

  .od-item-card{
    background:#ffffff;
    border-radius:16px;
    padding:16px 20px;
  }
  .od-item-name{
    font-size:15px;
    font-weight:800;
    color:var(--dark);
  }
  .od-item-qty{
    font-size:13px;
    font-weight:600;
    color:var(--muted);
  }
  .od-item-price{
    font-size:13px;
    color:var(--muted);
    margin-top:2px;
  }

  .od-total-card{
    background:#ffffff;
    border-radius:16px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .od-total-label{
    font-size:15px;
    color:var(--muted);
    font-weight:600;
  }
  .od-total-value{
    font-size:19px;
    font-weight:800;
    color:var(--dark);
  }

  @media (min-width:700px){
    .od-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
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

<div class="od-wrap">

  <div class="od-header">
    <a href="{{ route('customer.order.history') }}" class="od-back" aria-label="Kembali">
      <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <h1>Detail Pesanan</h1>
  </div>

  <div class="od-body">

    <div class="od-info-card">
      <div class="od-info-row">
        <span class="od-info-label">Nomor Pesanan</span>
        <span class="od-info-value">#{{ $order->id }}</span>
      </div>
      <div class="od-info-row">
        <span class="od-info-label">Meja</span>
        <span class="od-info-value">{{ $order->tabel->table_number ?? '-' }}</span>
      </div>
      <div class="od-info-row">
        <span class="od-info-label">Tanggal</span>
        <span class="od-info-value">{{ $order->created_at->diffForHumans() }}</span>
      </div>
    </div>

    <div class="od-status-badge">
      {{ $statusLabel[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
    </div>

    @foreach($order->orderItems as $item)
      <div class="od-item-card">
        <div class="od-item-name">{{ $item->menu_name }} <span class="od-item-qty">x{{ $item->qty }}</span></div>
        <div class="od-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
      </div>
    @endforeach

    <div class="od-total-card">
      <span class="od-total-label">Total</span>
      <span class="od-total-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

  </div>

</div>
</body>
</html>