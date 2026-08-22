<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Keranjang Kamu - Ruang Seduh</title>
<style>
  :root{
    --accent: #e07a5f;
    --dark: #141414;
    --muted: #8a8580;
    --cream: #f6ece3;
  }
  *{ box-sizing:border-box; margin:0; padding:0; }
  html, body{ height:100%; }
  body{ background:#0e0d0c; font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

  .ck-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: var(--cream);
    position:relative;
    overflow-x:hidden;
    display:flex;
    flex-direction:column;
  }

  .ck-header{ display:flex; align-items:center; gap:16px; padding:44px 20px 26px; }
  .ck-back{
    width:38px; height:38px; border-radius:50%;
    background:#ece0d2;
    display:flex; align-items:center; justify-content:center;
    text-decoration:none; color:var(--dark); flex-shrink:0; border:none; cursor:pointer;
  }
  .ck-back svg{ width:16px; height:16px; stroke:currentColor; stroke-width:2.4; fill:none; }
  .ck-header h1{
    font-family: Georgia, "Times New Roman", Times, serif;
    color:var(--dark); font-size:23px; font-weight:700;
  }

  .ck-body{ flex:1; padding:0 20px 130px; display:flex; flex-direction:column; }

  .ck-empty{ text-align:center; padding:40px 10px 0; }
  .ck-empty-text{ color:var(--muted); font-size:14px; line-height:1.7; }
  .ck-empty-logo{ margin-top:30px; display:flex; justify-content:center; opacity:0.8; }
  .ck-empty-logo img{ width:200px; height:auto; }

  .ck-item{
    background:#ffffff;
    border-radius:18px;
    padding:14px;
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:14px;
    box-shadow:0 4px 14px rgba(0,0,0,.04);
  }
  .ck-item-thumb{ width:56px; height:56px; border-radius:12px; overflow:hidden; flex-shrink:0; }
  .ck-item-thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
  .ck-item-thumb svg{ width:100%; height:100%; display:block; }
  .ck-item-info{ flex:1; min-width:0; }
  .ck-item-name{ font-size:15px; font-weight:800; color:var(--dark); }
  .ck-item-price{ font-size:13px; font-weight:700; color:#d1352e; margin-top:2px; }
  .ck-item-variant{ font-size:12px; color:var(--muted); margin-top:2px; }

  .ck-item-side{ display:flex; flex-direction:column; align-items:flex-end; gap:8px; flex-shrink:0; }

  .ck-stepper{ display:flex; align-items:center; gap:10px; flex-shrink:0; }
  .ck-step-btn{
    width:26px; height:26px; border-radius:8px;
    background:var(--dark); color:#fff; border:none;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; padding:0;
  }
  .ck-step-btn:disabled{ opacity:.35; cursor:not-allowed; }
  .ck-step-btn svg{ width:14px; height:14px; stroke:#fff; stroke-width:2.4; stroke-linecap:round; fill:none; }
  .ck-step-qty{ font-size:14px; font-weight:700; color:var(--dark); min-width:16px; text-align:center; }

  .ck-footer-wrap{ position:fixed; left:0; right:0; bottom:0; display:flex; justify-content:center; pointer-events:none; }
  .ck-footer{
    width:100%;
    max-width:480px;
    pointer-events:auto;
    background:#ffffff;
    border-radius:24px 24px 0 0;
    padding:18px 20px calc(18px + env(safe-area-inset-bottom));
    box-shadow: 0 -8px 30px rgba(0,0,0,.08);
  }
  .ck-total-row{ display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
  .ck-total-label{ font-size:14px; color:var(--muted); }
  .ck-total-value{ font-family: Georgia, "Times New Roman", Times, serif; font-size:17px; font-weight:700; color:var(--dark); }

  .ck-checkout-btn{
    display:block; text-align:center;
    width:100%; border:none; font-size:15px; font-weight:700;
    padding:16px 0; border-radius:999px; color:#fff;
    text-decoration:none;
  }
  .ck-checkout-btn.enabled{ background: var(--accent); box-shadow:0 10px 25px rgba(224,122,95,.4); cursor:pointer; }
  .ck-checkout-btn.disabled{ background:#f0c9bd; cursor:not-allowed; }

  @media (min-width:700px){
    body{ background:#111; }
    .ck-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

<div class="ck-wrap">

  <div class="ck-header">
    <a href="{{ route('customer.home') }}" class="ck-back" aria-label="Kembali">
      <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <h1>Keranjang Kamu</h1>
  </div>

  <div class="ck-body">
    @forelse($cart as $key => $item)
      <div class="ck-item">
        <div class="ck-item-thumb">
          @if($item['image'])
            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
          @else
            <svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
              <defs>
                <linearGradient id="thumbg{{ $loop->index }}" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#3d2b1f"/>
                  <stop offset="1" stop-color="#1a1210"/>
                </linearGradient>
              </defs>
              <rect width="100" height="100" fill="url(#thumbg{{ $loop->index }})"/>
            </svg>
          @endif
        </div>
        <div class="ck-item-info">
          <div class="ck-item-name">{{ $item['name'] }}</div>
          <div class="ck-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
          @if($item['variant'])
            <div class="ck-item-variant">{{ $item['variant'] }}</div>
          @endif
        </div>
        <div class="ck-item-side">
          <div class="ck-stepper">
            <button type="button" class="ck-step-btn" onclick="changeQty(@js($key), -1)" aria-label="Kurangi">
              <svg viewBox="0 0 24 24"><path d="M5 12h14"/></svg>
            </button>
            <span class="ck-step-qty" id="ckqty_{{ $key }}">{{ $item['qty'] }}</span>
            <button type="button" class="ck-step-btn" onclick="changeQty(@js($key), 1)" aria-label="Tambah">
              <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            </button>
          </div>
        </div>
      </div>
    @empty
      <div class="ck-empty">
        <div class="ck-empty-text">
          Keranjang masih kosong.<br>
          Yuk pilih menu favoritmu dulu &#9749;
        </div>
        <div class="ck-empty-logo">
          <img src="{{ asset('assets/images/LOGO_RUANG_SEDUH(coklat).png') }}" alt="Ruang Seduh">
        </div>
      </div>
    @endforelse
  </div>

  <div class="ck-footer-wrap">
    <div class="ck-footer">
      <div class="ck-total-row">
        <span class="ck-total-label">Total</span>
        <span class="ck-total-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
      </div>
      @if(Route::has('customer.checkout') && $total > 0)
        <a href="{{ route('customer.checkout') }}" class="ck-checkout-btn enabled">Checkout</a>
      @else
        <span class="ck-checkout-btn disabled">Checkout</span>
      @endif
    </div>
  </div>

</div>

<script>
  function changeQty(key, delta){
    const csfr = "{{ csrf_token() }}";
    const qtyKey = 'ckqty_' + key;
    let qty = parseInt(document.getElementById(qtyKey)?.textContent || '1') + delta;
    if (qty < 0) qty = 0;

    fetch("{{ route('customer.cart.update') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csfr,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ key: key, qty: qty }),
      credentials: 'same-origin'
    }).then(()=> window.location.reload());
  }
</script>
</body>
</html>