@php
  $currentTable = $currentTable ?? (session('customer_table_id') ? \App\Modules\Tables\Models\Tables::find(session('customer_table_id')) : null);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Ruang Seduh - Coffee & Artisan Brew</title>
<link rel="icon" href="{{ asset('assets/images/LOGO_RUANG_SEDUH(putih).png') }}" type="image/png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  :root {
    --bg: #f7f3ed;
    --card-bg: #ffffff;
    --dark: #231611;
    --espresso: #44241a;
    --espresso-hover: #351a12;
    --caramel: #8f654b;
    --muted: #8c7f76;
    --border: #eddcd0;
    --green-bg: #e6f4ea;
    --green-text: #1e7e34;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { height: 100%; }

  body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: var(--bg);
    color: var(--dark);
    -webkit-font-smoothing: antialiased;
  }

  .phone {
    width: 100%;
    max-width: 480px;
    margin: 0 auto;
    background: var(--bg);
    position: relative;
    min-height: 100dvh;
  }

  .content {
    padding: 22px 18px 115px;
  }

  /* ---- Header ---- */
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
  }

  .brand {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .brand-logo {
    width: 48px;
    height: 48px;
    background: #1c130f;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(28, 19, 15, 0.15);
    flex-shrink: 0;
    overflow: hidden;
  }

  .brand-logo img {
    width: 32px;
    height: 32px;
    object-fit: contain;
  }

  .brand-logo svg {
    width: 28px;
    height: 28px;
  }

  .brand-info {
    display: flex;
    flex-direction: column;
  }

  .brand-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.15;
    letter-spacing: -0.01em;
  }

  .brand-sub {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--caramel);
    margin-top: 2px;
  }

  /* ---- Table Badge (Kotak Biru - Otomatis dari Scan QR) ---- */
  .table-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    border: 1.5px solid var(--border);
    border-radius: 999px;
    padding: 6px 14px 6px 8px;
    box-shadow: 0 2px 8px rgba(70, 36, 26, 0.05);
    user-select: none;
  }

  .table-badge-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f7ede3;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--espresso);
    flex-shrink: 0;
  }

  .table-badge-icon svg {
    width: 17px;
    height: 17px;
  }

  .table-badge-text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.15;
  }

  .table-badge-label {
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--caramel);
  }

  .table-badge-val {
    font-size: 13px;
    font-weight: 800;
    color: var(--dark);
    white-space: nowrap;
  }

  .table-badge-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #1e7e34;
    box-shadow: 0 0 0 3px #d1e7dd;
    margin-left: 2px;
  }

  .table-badge.empty {
    border-style: dashed;
    background: #fdfbf8;
  }

  .table-badge.empty .table-badge-icon {
    background: #f1ede8;
    color: #8c7f76;
  }

  .table-badge.empty .table-badge-val {
    color: #8c7f76;
    font-weight: 700;
  }

  /* ---- Banner Iklan / Auto-Slider ---- */
  .ad-section {
    margin-bottom: 20px;
  }

  .ad-slider {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    background: linear-gradient(135deg, #fdf7f0 0%, #faede1 100%);
    border: 1px solid #eee1d3;
    box-shadow: 0 6px 20px rgba(70, 36, 26, 0.06);
    user-select: none;
    touch-action: pan-y;
  }

  .ad-track {
    display: flex;
    transition: transform 0.55s cubic-bezier(0.22, 1, 0.36, 1);
    width: 100%;
  }

  .ad-slide {
    min-width: 100%;
    flex-shrink: 0;
    padding: 26px 22px 30px;
    position: relative;
    min-height: 195px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
  }

  .ad-content {
    max-width: 62%;
    position: relative;
    z-index: 2;
  }

  .ad-eyebrow {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--caramel);
    margin-bottom: 8px;
    display: inline-block;
  }

  .ad-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 22px;
    font-weight: 700;
    line-height: 1.25;
    color: var(--dark);
    margin-bottom: 10px;
    letter-spacing: -0.01em;
  }

  .ad-title em {
    font-style: italic;
    color: var(--espresso);
  }

  .ad-desc {
    font-size: 12px;
    line-height: 1.45;
    color: #6e5e54;
  }

  .ad-art {
    position: absolute;
    right: -10px;
    bottom: -15px;
    width: 160px;
    height: 160px;
    pointer-events: none;
    z-index: 1;
  }

  .ad-art svg {
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 8px 18px rgba(70, 36, 26, 0.1));
  }

  /* Dots indicator */
  .ad-dots {
    position: absolute;
    left: 22px;
    bottom: 12px;
    display: flex;
    gap: 6px;
    align-items: center;
    z-index: 3;
  }

  .ad-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(70, 36, 26, 0.22);
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .ad-dot.active {
    width: 20px;
    border-radius: 999px;
    background: var(--espresso);
  }

  /* ---- Search Bar ---- */
  .search-row {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 18px;
  }

  .search-box {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 13px 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
  }

  .search-box svg {
    width: 18px;
    height: 18px;
    stroke: #8a7c73;
    fill: none;
    stroke-width: 2.2;
    flex-shrink: 0;
  }

  .search-box input {
    border: none;
    outline: none;
    background: none;
    font-size: 14px;
    font-family: inherit;
    width: 100%;
    color: var(--dark);
  }

  .search-box input::placeholder {
    color: #a4978e;
  }

  .filter-wrap {
    position: relative;
  }

  .filter-btn {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: var(--espresso);
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.15s ease, transform 0.15s ease;
    position: relative;
  }

  .filter-btn:active {
    transform: scale(0.95);
    background: var(--espresso-hover);
  }

  .filter-btn.has-filter {
    background: #231611;
    box-shadow: 0 0 0 2px #d97757;
  }

  .filter-btn svg {
    width: 20px;
    height: 20px;
    stroke: #ffffff;
    fill: none;
    stroke-width: 2;
  }

  .filter-badge-dot {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #e07a5f;
    border: 2px solid #ffffff;
  }

  .filter-popover {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    width: 250px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 12px 36px rgba(35, 22, 17, 0.18);
    border: 1px solid var(--border);
    padding: 14px;
    z-index: 50;
    animation: fadeInModal 0.18s ease;
  }

  .filter-popover-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f0e5dc;
  }

  .filter-popover-title {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--caramel);
  }

  .filter-popover-close {
    background: none;
    border: none;
    font-size: 18px;
    line-height: 1;
    color: #a4978e;
    cursor: pointer;
    padding: 2px;
  }

  .filter-options {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .filter-opt {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 12px;
    border-radius: 12px;
    border: 1px solid transparent;
    background: transparent;
    text-align: left;
    cursor: pointer;
    transition: all 0.15s ease;
    font-family: inherit;
  }

  .filter-opt:hover {
    background: #fdf8f4;
  }

  .filter-opt.active {
    background: #f7ede3;
    border-color: #ebdcd0;
  }

  .filter-opt-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--espresso);
    flex-shrink: 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }

  .filter-opt-icon svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
  }

  .filter-opt-body {
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .filter-opt-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
  }

  .filter-opt-desc {
    font-size: 10px;
    color: #8c7f76;
    margin-top: 1px;
  }

  .filter-check {
    font-size: 13px;
    color: var(--espresso);
    font-weight: 800;
    opacity: 0;
    transition: opacity 0.15s ease;
  }

  .filter-opt.active .filter-check {
    opacity: 1;
  }

  .sort-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 999px;
    background: #f2e6db;
    color: var(--espresso);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
  }

  .sort-tag:hover {
    background: #e7d5c5;
  }

  /* ---- Categories (Clean text without coffee icon) ---- */
  .categories {
    display: flex;
    gap: 9px;
    overflow-x: auto;
    margin-bottom: 22px;
    scrollbar-width: none;
    padding-bottom: 2px;
  }

  .categories::-webkit-scrollbar { display: none; }

  .chip {
    flex-shrink: 0;
    padding: 10px 20px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    background: #ffffff;
    color: #55372b;
    border: 1px solid var(--border);
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
  }

  .chip.active {
    background: var(--espresso);
    color: #ffffff;
    border-color: var(--espresso);
    box-shadow: 0 4px 12px rgba(68, 36, 26, 0.25);
  }

  /* ---- Section Header ---- */
  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 16px;
  }

  .section-eyebrow {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--caramel);
    display: block;
    margin-bottom: 4px;
  }

  .section-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 24px;
    font-weight: 700;
    color: var(--dark);
    letter-spacing: -0.01em;
  }

  .item-count {
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
  }

  /* ---- Menu Grid ---- */
  .grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .card {
    display: flex;
    flex-direction: column;
    background: var(--card-bg);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(70, 36, 26, 0.05);
    border: 1px solid #f0e6dd;
    text-decoration: none;
    color: inherit;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }

  .card:active {
    transform: scale(0.98);
  }

  .thumb {
    height: 135px;
    width: 100%;
    position: relative;
    background: #251611;
    overflow: hidden;
  }

  .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
  }

  .card:hover .thumb img {
    transform: scale(1.04);
  }

  .thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3d2319 0%, #20130d 100%);
  }

  .thumb-placeholder svg {
    width: 50px;
    height: 50px;
    opacity: 0.75;
  }

  .card-body {
    padding: 12px 14px 14px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .card-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 6px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
  }

  .card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
    margin-top: auto;
  }

  .card-price {
    font-size: 14px;
    font-weight: 800;
    color: var(--dark);
    white-space: nowrap;
  }

  .stock-pill {
    display: inline-flex;
    align-items: center;
    padding: 3px 7px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    background: var(--green-bg);
    color: var(--green-text);
    white-space: nowrap;
  }

  .stock-pill.empty {
    background: #fee2e2;
    color: #b91c1c;
  }

  /* ---- Bottom Navbar ---- */
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
    color: var(--espresso);
    font-weight: 800;
  }

  .nav-link.active svg {
    stroke: var(--espresso);
  }

  @media (min-width: 700px) {
    body { background: #16100d; }
    .phone {
      margin: 24px auto;
      border-radius: 30px;
      box-shadow: 0 25px 70px rgba(0,0,0,0.5);
      overflow: hidden;
    }
  }
</style>
</head>
<body>

<div class="phone">
  <div class="content">

    <!-- Header Logo & Table Badge (Kotak Biru) -->
    <header class="header">
      <div class="brand">
        <div class="brand-logo">
          <img src="{{ asset('assets/images/LOGO_RUANG_SEDUH(putih).png') }}" alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
          <svg viewBox="0 0 24 24" fill="none" stroke="#f6ece3" stroke-width="2" style="display:none;">
            <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
            <line x1="6" y1="1" x2="6" y2="4"/>
            <line x1="10" y1="1" x2="10" y2="4"/>
            <line x1="14" y1="1" x2="14" y2="4"/>
          </svg>
        </div>
        <div class="brand-info">
          <h1 class="brand-title">Ruang Seduh</h1>
          <span class="brand-sub">COFFEE & ARTISAN BREW</span>
        </div>
      </div>

      <!-- Kotak Biru: Nomor Meja Otomatis dari Scan QR -->
      @if($currentTable)
        <div class="table-badge active" id="tableBadge" title="Meja {{ $currentTable->table_number }}">
          <div class="table-badge-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 10h16M5 10v9M19 10v9M4 14h16M8 10v4M16 10v4"/>
            </svg>
          </div>
          <div class="table-badge-text">
            <span class="table-badge-label">MEJA</span>
            <span class="table-badge-val">{{ $currentTable->table_number }}</span>
          </div>
          <span class="table-badge-dot" title="Tersambung ke Meja {{ $currentTable->table_number }}"></span>
        </div>
      @else
        <div class="table-badge empty" id="tableBadge" title="Silakan scan QR pada meja Anda">
          <div class="table-badge-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 10h16M5 10v9M19 10v9M4 14h16M8 10v4M16 10v4"/>
            </svg>
          </div>
          <div class="table-badge-text">
            <span class="table-badge-label">MEJA</span>
            <span class="table-badge-val">-</span>
          </div>
        </div>
      @endif
    </header>

    <!-- Banner Iklan Auto-Slide (Carousel) -->
    <section class="ad-section">
      <div class="ad-slider" id="adSlider">
        <div class="ad-track" id="adTrack">

          <!-- Slide 1 -->
          <div class="ad-slide">
            <div class="ad-content">
              <span class="ad-eyebrow">GOOD COFFEE • GOOD MOOD</span>
              <h2 class="ad-title">Kopi yang bikin<br><em>hari lebih baik.</em></h2>
              <p class="ad-desc">Ruang untuk jeda, rasa untuk cerita.</p>
            </div>
            <div class="ad-art">
              <!-- Stylized Coffee Cup & Heart Latte Art -->
              <svg viewBox="0 0 160 160" fill="none">
                <circle cx="85" cy="85" r="55" fill="#edd5be" opacity="0.6"/>
                <!-- Saucer -->
                <ellipse cx="80" cy="115" rx="55" ry="18" fill="#d8bda5"/>
                <ellipse cx="80" cy="112" rx="48" ry="14" fill="#eddcd0"/>
                <!-- Cup body -->
                <path d="M42 65 C42 105 118 105 118 65 Z" fill="#ffffff"/>
                <ellipse cx="80" cy="65" rx="38" ry="14" fill="#ffffff"/>
                <!-- Coffee liquid -->
                <ellipse cx="80" cy="65" rx="34" ry="11" fill="#4a251b"/>
                <!-- Latte art heart -->
                <path d="M80 67 C78 64 74 63 72 65 C69 67 70 70 80 74 C90 70 91 67 88 65 C86 63 82 64 80 67 Z" fill="#eddcd0" opacity="0.95"/>
                <!-- Cup handle -->
                <path d="M115 72 C125 72 128 85 116 88" stroke="#ffffff" stroke-width="6" stroke-linecap="round" fill="none"/>
                <!-- Gentle steam -->
                <path d="M72 44 Q70 36 74 30" stroke="#cbb39e" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.7"/>
                <path d="M82 42 Q86 34 82 28" stroke="#cbb39e" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.7"/>
              </svg>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="ad-slide">
            <div class="ad-content">
              <span class="ad-eyebrow">SPECIAL ARTISAN BREW</span>
              <h2 class="ad-title">Cita rasa kopi<br><em>khas Nusantara.</em></h2>
              <p class="ad-desc">Diseduh presisi dari biji pilihan barista kami.</p>
            </div>
            <div class="ad-art">
              <!-- Stylized Iced Coffee Glass -->
              <svg viewBox="0 0 160 160" fill="none">
                <circle cx="85" cy="85" r="55" fill="#f0dbcb" opacity="0.6"/>
                <!-- Tall Glass -->
                <path d="M60 40 L68 120 C68 125 92 125 92 120 L100 40 Z" fill="#ffffff" opacity="0.85"/>
                <!-- Drink gradient -->
                <path d="M62 55 L68 118 C70 122 90 122 92 118 L98 55 Z" fill="#582a1e"/>
                <!-- Milk blend top -->
                <ellipse cx="80" cy="55" rx="18" ry="6" fill="#dfc0aa"/>
                <!-- Ice Cubes -->
                <rect x="70" y="65" width="12" height="12" rx="3" fill="#ffffff" opacity="0.5" transform="rotate(15 70 65)"/>
                <rect x="78" y="85" width="14" height="13" rx="3" fill="#ffffff" opacity="0.4" transform="rotate(-10 78 85)"/>
                <!-- Straw -->
                <line x1="88" y1="24" x2="74" y2="100" stroke="#d97757" stroke-width="4" stroke-linecap="round"/>
              </svg>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="ad-slide">
            <div class="ad-content">
              <span class="ad-eyebrow">FRESH FROM THE OVEN</span>
              <h2 class="ad-title">Pastry renyah &<br><em>hangat hari ini.</em></h2>
              <p class="ad-desc">Teman ngopi paling pas untuk temani harimu.</p>
            </div>
            <div class="ad-art">
              <!-- Stylized Croissant / Bakery -->
              <svg viewBox="0 0 160 160" fill="none">
                <circle cx="85" cy="85" r="55" fill="#fae4d0" opacity="0.6"/>
                <!-- Croissant curve -->
                <ellipse cx="80" cy="92" rx="40" ry="18" fill="#d98943"/>
                <ellipse cx="80" cy="88" rx="34" ry="16" fill="#e89d52"/>
                <path d="M50 94 C55 80 75 75 80 82 C85 75 105 80 110 94 C100 102 60 102 50 94 Z" fill="#f5af64"/>
                <path d="M68 84 Q80 76 92 84" stroke="#c4742a" stroke-width="3" fill="none"/>
                <path d="M72 90 Q80 84 88 90" stroke="#c4742a" stroke-width="2.5" fill="none"/>
                <!-- Sparkles -->
                <circle cx="50" cy="55" r="3" fill="#d98943"/>
                <circle cx="108" cy="58" r="2.5" fill="#d98943"/>
              </svg>
            </div>
          </div>

        </div>

        <!-- Dots indicator -->
        <div class="ad-dots" id="adDots">
          <span class="ad-dot active" data-index="0"></span>
          <span class="ad-dot" data-index="1"></span>
          <span class="ad-dot" data-index="2"></span>
        </div>
      </div>
    </section>

    <!-- Search Box with Filter (Kotak Kuning) -->
    <div class="search-row">
      <div class="search-box">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" id="searchInput" placeholder="Cari menu favorit kamu...">
      </div>

      <div class="filter-wrap">
        <button type="button" class="filter-btn" id="filterBtn" aria-label="Filter Urutan Menu" title="Urutkan Harga">
          <svg viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
          </svg>
          <span class="filter-badge-dot" id="filterBadgeDot" style="display:none;"></span>
        </button>

        <!-- Popover Filter Menu (Kotak Kuning) -->
        <div class="filter-popover" id="filterPopover" style="display:none;">
          <div class="filter-popover-header">
            <span class="filter-popover-title">Urutkan Harga</span>
            <button type="button" class="filter-popover-close" id="filterPopoverClose">&times;</button>
          </div>
          <div class="filter-options">
            <button type="button" class="filter-opt active" data-sort="default">
              <div class="filter-opt-icon">
                <svg viewBox="0 0 24 24"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="14" y2="12"/><line x1="4" y1="18" x2="8" y2="18"/></svg>
              </div>
              <div class="filter-opt-body">
                <span class="filter-opt-label">Default</span>
                <span class="filter-opt-desc">Urutan rekomendasi menu</span>
              </div>
              <span class="filter-check">✓</span>
            </button>
            <button type="button" class="filter-opt" data-sort="highest">
              <div class="filter-opt-icon">
                <svg viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
              </div>
              <div class="filter-opt-body">
                <span class="filter-opt-label">Harga Tertinggi</span>
                <span class="filter-opt-desc">Dari paling mahal ke murah</span>
              </div>
              <span class="filter-check">✓</span>
            </button>
            <button type="button" class="filter-opt" data-sort="lowest">
              <div class="filter-opt-icon">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
              </div>
              <div class="filter-opt-body">
                <span class="filter-opt-label">Harga Terendah</span>
                <span class="filter-opt-desc">Dari paling murah ke mahal</span>
              </div>
              <span class="filter-check">✓</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Chips (No coffee cup icons) -->
    <div class="categories" id="categoriesContainer">
      <div class="chip active" data-category="Semua">Semua</div>
      @foreach($categories as $category)
        <div class="chip" data-category="{{ $category->name }}">{{ $category->name }}</div>
      @endforeach
    </div>

    <!-- Section Header: OUR SELECTION / Semua Menu / Count -->
    <div class="section-header">
      <div>
        <span class="section-eyebrow">OUR SELECTION</span>
        <h2 class="section-title" id="sectionTitle">Semua Menu</h2>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <span class="sort-tag" id="sortTag" style="display:none;" title="Klik untuk reset ke urutan default"></span>
        <span class="item-count" id="itemCount">{{ count($menus) }} item</span>
      </div>
    </div>

    <!-- Menu Grid -->
    <div class="grid" id="menuGrid">
      @forelse($menus as $index => $menu)
        <a href="{{ route('customer.menu.show', $menu->id) }}" 
           class="card" 
           data-name="{{ $menu->name }}" 
           data-category="{{ $menu->kategori->name ?? '' }}"
           data-price="{{ (float) $menu->price }}"
           data-original-index="{{ $index }}">
          <div class="thumb">
            @if($menu->image)
              <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" loading="lazy">
            @else
              <div class="thumb-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="#d5b89f" stroke-width="1.6">
                  <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                  <line x1="6" y1="1" x2="6" y2="4"/>
                  <line x1="10" y1="1" x2="10" y2="4"/>
                  <line x1="14" y1="1" x2="14" y2="4"/>
                </svg>
              </div>
            @endif
          </div>
          <div class="card-body">
            <div class="card-name">{{ $menu->name }}</div>
            <div class="card-footer">
              <span class="card-price">{{ $menu->hargaRupiah() }}</span>
              @if($menu->stock > 0)
                <span class="stock-pill">Tersedia {{ $menu->stock }}</span>
              @else
                <span class="stock-pill empty">Habis</span>
              @endif
            </div>
          </div>
        </a>
      @empty
        <div style="grid-column:1/-1; text-align:center; color:var(--muted); padding:40px 0; font-size:13px;">
          Menu tidak tersedia saat ini.
        </div>
      @endforelse
    </div>

  </div>

  <!-- Bottom Navbar: Beranda, Riwayat, Keranjang, Profil -->
  <div class="navbar-wrap">
    <nav class="navbar" id="navbar">
      <a href="{{ route('customer.home') }}" class="nav-link active" aria-label="Beranda">
        <svg viewBox="0 0 24 24">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <span>Beranda</span>
      </a>
      <a href="{{ route('customer.order.history') }}" class="nav-link" aria-label="Riwayat">
        <svg viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <span>Riwayat</span>
      </a>
      <a href="{{ route('customer.cart.index') }}" class="nav-link" aria-label="Keranjang">
        <svg viewBox="0 0 24 24">
          <circle cx="9" cy="21" r="1"/>
          <circle cx="20" cy="21" r="1"/>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        <span>Keranjang</span>
      </a>
      <a href="{{ route('customer.profile.index') }}" class="nav-link" aria-label="Profil">
        <svg viewBox="0 0 24 24">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Profil</span>
      </a>
    </nav>
  </div>
</div>

<script>
  // ---- Auto-sliding Ad Carousel ----
  (function initCarousel() {
    const track = document.getElementById('adTrack');
    const dots = document.querySelectorAll('.ad-dot');
    const slides = document.querySelectorAll('.ad-slide');
    const total = slides.length;
    let current = 0;
    let timer = null;

    function goToSlide(index) {
      current = (index + total) % total;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === current);
      });
    }

    function nextSlide() {
      goToSlide(current + 1);
    }

    function startAutoSlide() {
      stopAutoSlide();
      timer = setInterval(nextSlide, 4500);
    }

    function stopAutoSlide() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    dots.forEach((dot) => {
      dot.addEventListener('click', () => {
        goToSlide(parseInt(dot.dataset.index, 10));
        startAutoSlide();
      });
    });

    // Touch / Swipe support for mobile
    let startX = 0;
    let currentX = 0;
    let isSwiping = false;
    const slider = document.getElementById('adSlider');

    slider.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
      isSwiping = true;
      stopAutoSlide();
    }, { passive: true });

    slider.addEventListener('touchmove', (e) => {
      if (!isSwiping) return;
      currentX = e.touches[0].clientX;
    }, { passive: true });

    slider.addEventListener('touchend', () => {
      if (!isSwiping) return;
      isSwiping = false;
      const diff = currentX - startX;
      if (Math.abs(diff) > 40) {
        if (diff < 0) {
          nextSlide();
        } else {
          goToSlide(current - 1);
        }
      }
      startAutoSlide();
    });

    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);

    startAutoSlide();
  })();

  // ---- Search, Category & Price Filtering (Kotak Kuning) ----
  (function initFilteringAndSorting() {
    const grid = document.getElementById('menuGrid');
    const sectionTitle = document.getElementById('sectionTitle');
    const itemCount = document.getElementById('itemCount');
    const searchInput = document.getElementById('searchInput');
    const chips = document.querySelectorAll('.chip');
    const cards = Array.from(document.querySelectorAll('#menuGrid .card'));

    // Filter Popover Elements (Kotak Kuning)
    const filterBtn = document.getElementById('filterBtn');
    const filterPopover = document.getElementById('filterPopover');
    const filterPopoverClose = document.getElementById('filterPopoverClose');
    const filterOpts = document.querySelectorAll('.filter-opt');
    const filterBadgeDot = document.getElementById('filterBadgeDot');
    const sortTag = document.getElementById('sortTag');

    let currentSort = 'default'; // 'default', 'highest', 'lowest'

    // Toggle filter popover
    if (filterBtn && filterPopover) {
      filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isShown = filterPopover.style.display === 'block';
        filterPopover.style.display = isShown ? 'none' : 'block';
      });

      if (filterPopoverClose) {
        filterPopoverClose.addEventListener('click', (e) => {
          e.stopPropagation();
          filterPopover.style.display = 'none';
        });
      }

      document.addEventListener('click', (e) => {
        if (!filterPopover.contains(e.target) && e.target !== filterBtn && !filterBtn.contains(e.target)) {
          filterPopover.style.display = 'none';
        }
      });
    }

    // Sort options click
    filterOpts.forEach(opt => {
      opt.addEventListener('click', () => {
        filterOpts.forEach(o => o.classList.remove('active'));
        opt.classList.add('active');

        currentSort = opt.dataset.sort || 'default';
        applySort();

        if (filterPopover) {
          filterPopover.style.display = 'none';
        }
      });
    });

    // Reset sort when clicking sort tag
    if (sortTag) {
      sortTag.addEventListener('click', () => {
        const defaultOpt = document.querySelector('.filter-opt[data-sort="default"]');
        if (defaultOpt) defaultOpt.click();
      });
    }

    function applySort() {
      // Update filter UI indicators
      if (currentSort !== 'default') {
        if (filterBadgeDot) filterBadgeDot.style.display = 'block';
        if (filterBtn) filterBtn.classList.add('has-filter');
        if (sortTag) {
          const label = currentSort === 'highest' ? 'Harga Tertinggi ✕' : 'Harga Terendah ✕';
          sortTag.textContent = label;
          sortTag.style.display = 'inline-flex';
        }
      } else {
        if (filterBadgeDot) filterBadgeDot.style.display = 'none';
        if (filterBtn) filterBtn.classList.remove('has-filter');
        if (sortTag) sortTag.style.display = 'none';
      }

      // Re-order cards array
      cards.sort((a, b) => {
        if (currentSort === 'highest') {
          return parseFloat(b.dataset.price || 0) - parseFloat(a.dataset.price || 0);
        } else if (currentSort === 'lowest') {
          return parseFloat(a.dataset.price || 0) - parseFloat(b.dataset.price || 0);
        } else {
          return parseInt(a.dataset.originalIndex || 0) - parseInt(b.dataset.originalIndex || 0);
        }
      });

      // Re-append cards in sorted order to grid
      cards.forEach(card => grid.appendChild(card));

      // Re-apply visibility filtering
      renderMenu();
    }

    function renderMenu() {
      const activeChip = document.querySelector('.chip.active');
      const category = activeChip ? activeChip.dataset.category : 'Semua';
      const keyword = (searchInput ? searchInput.value : '').trim().toLowerCase();

      let visible = 0;
      cards.forEach(card => {
        const name = (card.dataset.name || '').toLowerCase();
        const cat = card.dataset.category || '';

        const matchCategory = category === 'Semua' || cat === category;
        const matchKeyword = !keyword || name.includes(keyword);

        if (matchCategory && matchKeyword) {
          card.style.display = 'flex';
          visible++;
        } else {
          card.style.display = 'none';
        }
      });

      if (sectionTitle) {
        sectionTitle.textContent = category === 'Semua' ? 'Semua Menu' : category;
      }
      if (itemCount) {
        itemCount.textContent = `${visible} item`;
      }

      let empty = grid.querySelector('.grid-empty');
      if (visible === 0) {
        if (!empty) {
          empty = document.createElement('div');
          empty.className = 'grid-empty';
          empty.style.cssText = 'grid-column: 1/-1; text-align: center; color: var(--muted); padding: 40px 0; font-size: 13px; font-weight: 500;';
          empty.textContent = 'Menu tidak ditemukan.';
          grid.appendChild(empty);
        }
      } else if (empty) {
        empty.remove();
      }
    }

    // Category chips click
    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        renderMenu();
      });
    });

    // Search input
    if (searchInput) {
      searchInput.addEventListener('input', renderMenu);
    }

    renderMenu();
  })();
</script>
</body>
</html>