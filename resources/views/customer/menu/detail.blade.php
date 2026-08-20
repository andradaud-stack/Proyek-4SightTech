<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>{{ $menu->name }} - Ruang Seduh</title>
<style>
  :root{
    --accent: #e07a5f;
    --dark: #141414;
    --muted: #b8afa6;
  }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #111;
  }
  .pd-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background:#0e0d0c;
    position:relative;
    font-family:inherit;
    overflow-x:hidden;
  }

  /* Hero image */
  .pd-hero{
    position:relative;
    width:100%;
    height:60vh;
    min-height:380px;
    overflow:hidden;
  }
  .pd-hero img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
  }
  .pd-hero-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(180deg, #2a1c14 0%, #120c09 100%);
  }
  .pd-hero-fallback svg{ width:100%; height:100%; }
  .pd-back{
    position:absolute;
    top:20px;
    left:20px;
    z-index:5;
    width:38px;
    height:38px;
    border-radius:50%;
    background:rgba(255,255,255,0.85);
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:#141414;
    box-shadow:0 4px 10px rgba(0,0,0,.2);
  }
  .pd-back svg{ width:18px; height:18px; stroke:currentColor; stroke-width:2.2; fill:none; }

  /* Bottom sheet */
  .pd-sheet{
    position:relative;
    margin-top:-40px;
    background: linear-gradient(180deg, #241814 0%, #17110f 100%);
    border-radius:32px 32px 0 0;
    padding:28px 24px 32px;
    color:#fff;
    min-height:calc(40vh + 40px);
  }

  .pd-top-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    margin-bottom:14px;
  }
  .pd-name{
    font-size:26px;
    font-weight:800;
    line-height:1.15;
  }
  .pd-price{
    flex-shrink:0;
    background:var(--accent);
    color:#fff;
    font-weight:700;
    font-size:14px;
    padding:8px 16px;
    border-radius:999px;
    box-shadow:0 4px 14px rgba(224,122,95,.4);
    white-space:nowrap;
    margin-top:2px;
  }

  .pd-desc{
    color:var(--muted);
    font-size:14px;
    line-height:1.6;
    margin-bottom:26px;
  }

  .pd-section-title{
    font-size:17px;
    font-weight:700;
    margin-bottom:12px;
  }

  .pd-variants{
    display:flex;
    gap:10px;
    margin-bottom:30px;
  }
  .pd-variant{
    flex:1;
    text-align:center;
    padding:12px 0;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    border:2px solid transparent;
    background:#2b211d;
    color:#fff;
    transition: all .15s ease;
  }
  .pd-variant.active{
    background:transparent;
    border-color:var(--accent);
    color:var(--accent);
  }

  .pd-cta{
    width:100%;
    border:none;
    background:var(--accent);
    color:#fff;
    font-size:16px;
    font-weight:700;
    padding:16px 0;
    border-radius:999px;
    cursor:pointer;
    box-shadow:0 10px 25px rgba(224,122,95,.45);
    transition: transform .15s ease;
  }
  .pd-cta:active{ transform: scale(0.97); }
  .pd-cta:disabled{
    opacity:.55;
    cursor:not-allowed;
    box-shadow:none;
  }

  @media (min-width:700px){
    body{ background:#111; }
    .pd-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

<div class="pd-wrap">

  <div class="pd-hero">
    <a href="{{ route('customer.home') }}" class="pd-back" aria-label="Kembali">
      <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    @if($menu->image)
      <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
    @else
      <div class="pd-hero-fallback">
        <svg viewBox="0 0 240 320" preserveAspectRatio="xMidYMid slice">
          <defs>
            <linearGradient id="hf" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#3d2b1f"/>
              <stop offset="1" stop-color="#1a1210"/>
            </linearGradient>
          </defs>
          <rect width="240" height="320" fill="#1a1210"/>
          <ellipse cx="120" cy="150" rx="80" ry="60" fill="url(#hf)"/>
          <rect x="60" y="130" width="120" height="90" rx="12" fill="#3d2b1f" opacity="0.9"/>
          <ellipse cx="120" cy="130" rx="60" ry="22" fill="#1a1210" opacity="0.85"/>
        </svg>
      </div>
    @endif
  </div>

  <div class="pd-sheet">

    <div class="pd-top-row">
      <div class="pd-name">{{ $menu->name }}</div>
      <div class="pd-price">{{ number_format($menu->price / 1000, 0) }}K</div>
    </div>

    <div class="pd-desc">
      {{ $menu->description }}
    </div>

    @php
      $variants = $menu->variants ?? ['Ice', 'Hot'];
    @endphp

    @if(!empty($variants))
    <div class="pd-section-title">Pilih Varian</div>
    <div class="pd-variants" id="pdVariants">
      @foreach($variants as $i => $variant)
        <div class="pd-variant {{ $i === 0 ? 'active' : '' }}" data-variant="{{ $variant }}">
          {{ $variant }}
        </div>
      @endforeach
    </div>
    @endif

    @if(Route::has('customer.cart.add'))
      <form action="{{ route('customer.cart.add') }}" method="POST" id="pdForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $menu->id }}">
        @if(!empty($variants))
          <input type="hidden" name="variant" id="pdVariantInput" value="{{ $variants[0] }}">
        @endif
        <button type="submit" class="pd-cta">Tambah ke keranjang</button>
      </form>
    @else
      <button type="button" class="pd-cta" disabled>Tambah ke keranjang</button>
    @endif

  </div>
</div>

<script>
  const variantEls = document.querySelectorAll('.pd-variant');
  const variantInput = document.getElementById('pdVariantInput');
  variantEls.forEach(el=>{
    el.addEventListener('click', ()=>{
      variantEls.forEach(v=>v.classList.remove('active'));
      el.classList.add('active');
      if (variantInput) variantInput.value = el.dataset.variant;
    });
  });
</script>
</body>
</html>