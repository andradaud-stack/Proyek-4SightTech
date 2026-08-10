<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Ruang Seduh</title>
<style>
  :root{
    --bg: #f7f3ee;
    --card-bg: #ffffff;
    --dark: #141414;
    --maroon: #5a1f1f;
    --price: #d1352e;
    --muted: #8a8580;
    --accent: #e07a5f;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{
    height:100%;
  }
  body{
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background:var(--bg);
  }

  .phone{
    width:100%;
    max-width:480px;
    margin:0 auto;
    background:var(--bg);
    position:relative;
    min-height:100dvh;
  }

  .content{
    padding:24px 20px 120px;
  }

  /* Header */
  .header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:20px;
  }
  .greet-sub{
    font-size:13px;
    color:var(--muted);
    margin-bottom:2px;
  }
  .greet-name{
    font-size:19px;
    font-weight:700;
    color:var(--dark);
  }
  .logo{ 
    width: 60px; 
    height: auto; 
    object-fit: contain; 
  }

  /* Search */
  .search-bar{
    display:flex;
    align-items:center;
    gap:10px;
    background:#fff;
    border:1px solid #eee2d8;
    border-radius:14px;
    padding:12px 16px;
    margin-bottom:16px;
  }
  .search-bar svg{
    width:18px; height:18px;
    stroke:var(--muted);
    fill:none;
    stroke-width:2;
    flex-shrink:0;
  }
  .search-bar input{
    border:none;
    outline:none;
    background:none;
    font-size:14px;
    width:100%;
    color:var(--dark);
  }
  .search-bar input::placeholder{ color:#b5afa7; }

  /* Category pills */
  .categories{
    display:flex;
    gap:8px;
    overflow-x:auto;
    margin-bottom:22px;
    scrollbar-width:none;
  }
  .categories::-webkit-scrollbar{display:none;}
  .chip{
    flex-shrink:0;
    padding:9px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
    background:#fff;
    color:var(--maroon);
    border:1px solid #eee2d8;
    cursor:pointer;
    white-space:nowrap;
    transition: all .15s ease;
  }
  .chip.active{
    background:var(--maroon);
    color:#fff;
    border-color:var(--maroon);
  }

  .section-title{
    font-size:17px;
    font-weight:700;
    color:var(--dark);
    margin-bottom:14px;
  }

  /* Menu grid */
  .grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
  }
  .card{
    background:var(--card-bg);
    border-radius:16px;
    overflow:hidden;
    box-shadow: 0 4px 14px rgba(0,0,0,.05);
    cursor:pointer;
    transition: transform .15s ease;
  }
  .card:hover{ transform: translateY(-3px); }

  .thumb{
    height:110px;
    width:100%;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
  }
  .thumb svg{ width:100%; height:100%; }

  .card-body{
    padding:10px 12px 14px;
  }
  .card-tag{
    font-size:10px;
    letter-spacing:.03em;
    text-transform:uppercase;
    color:var(--muted);
    margin-bottom:4px;
  }
  .card-name{
    font-size:14px;
    font-weight:700;
    color:var(--dark);
    margin-bottom:4px;
  }
  .card-price{
    font-size:13px;
    font-weight:700;
    color:var(--price);
  }

  /* Bottom Navbar (floating, fixed to real screen) */
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
    transition: background .2s ease, transform .15s ease;
  }
  .nav-item svg{
    width:22px; height:22px;
    stroke:var(--dark);
    stroke-width:1.8;
    fill:none;
    transition: stroke .2s ease;
  }
  .nav-item:hover{ transform: translateY(-2px); }
  .nav-item.active{
    background: var(--accent);
    box-shadow: 0 0 0 4px #ffffff, 0 4px 10px rgba(224,122,95,0.5);
  }
  .nav-item.active svg{ stroke:#ffffff; }

  @media (max-width: 340px){
    .content{ padding:20px 14px 120px; }
    .greet-name{ font-size:17px; }
    .logo{ font-size:19px; }
    .grid{ gap:10px; }
    .card-name{ font-size:13px; }
    .nav-item{ padding:7px; }
    .nav-item svg{ width:19px; height:19px; }
  }

  @media (min-width: 700px){
    .phone{ max-width:420px; margin-top:24px; margin-bottom:24px; border-radius:28px; box-shadow:0 20px 60px rgba(0,0,0,.25); overflow:hidden; }
    body{ background:#1b1b1b; }
  }
</style>
</head>
<body>

<div class="phone">
  <div class="content">

    <div class="header">
      <div>
        <div class="greet-sub">Selamat Datang,</div>
        <div class="greet-name">Guntur Syabudi</div>
      </div>
      <img
            src="{{ asset('assets/images/LOGO_RUANG_SEDUH(coklat).png') }}"
            class="logo"
            alt="Logo">
    </div>

    <div class="search-bar">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
      <input type="text" id="searchInput" placeholder="Cari menu, misal: Americano">
    </div>

    <div class="categories">
      <div class="chip active" data-category="Semua">Semua</div>
      <div class="chip" data-category="Coffee Based">Coffee Based</div>
      <div class="chip" data-category="Non-Coffee">Non-Coffee</div>
      <div class="chip" data-category="Pastry">Pastry</div>
    </div>

    <div class="section-title" id="sectionTitle">Semua Menu</div>

    <div class="grid" id="menuGrid"></div>

  </div>

  <div class="navbar-wrap">
  <nav class="navbar" id="navbar">
    <button class="nav-item" data-name="profile" aria-label="Profil">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
    </button>
    <button class="nav-item" data-name="history" aria-label="Riwayat">
      <svg viewBox="0 0 24 24">
        <rect x="5" y="4" width="14" height="17" rx="2"/>
        <path d="M9 2h6v3H9z"/>
        <circle cx="12" cy="14" r="3.2"/>
        <path d="M12 12.5v1.7l1.2 1"/>
      </svg>
    </button>
    <button class="nav-item active" data-name="home" aria-label="Beranda">
      <svg viewBox="0 0 24 24"><path d="M4 11 12 4l8 7"/><path d="M6 10v9h12v-9"/></svg>
    </button>
    <button class="nav-item" data-name="cart" aria-label="Keranjang">
      <svg viewBox="0 0 24 24">
        <path d="M4 5h2l1.5 10.5A2 2 0 0 0 9.5 17h7a2 2 0 0 0 2-1.7L20 8H6.2"/>
        <circle cx="10" cy="20" r="1.2" fill="currentColor" stroke="none"/>
        <circle cx="17" cy="20" r="1.2" fill="currentColor" stroke="none"/>
      </svg>
    </button>
    <button class="nav-item" data-name="notification" aria-label="Notifikasi">
      <svg viewBox="0 0 24 24">
        <path d="M6 10a6 6 0 0 1 12 0c0 4 1.5 5.5 1.5 5.5H4.5S6 14 6 10Z"/>
        <path d="M10 19a2 2 0 0 0 4 0"/>
      </svg>
    </button>
  </nav>
  </div>
</div>

<script>
  // ---- Data menu ----
  const menu = [
    { tag:"Coffee Based", name:"Americano", price:"Rp 23.000", grad:["#3d2b1f","#1a1210"], drink:true },
    { tag:"Coffee Based", name:"Espresso", price:"Rp 21.000", grad:["#5c3a24","#2b1a10"], drink:true },
    { tag:"Coffee Based", name:"Cappuccino", price:"Rp 29.000", grad:["#c9a06b","#8a5a2f"], drink:true },
    { tag:"Coffee Based", name:"Mochaccino", price:"Rp 30.000", grad:["#7a4a2b","#3c2413"], drink:true },
    { tag:"Coffee Based", name:"Cafe Latte", price:"Rp 29.000", grad:["#c9ad7e","#7a4a2b"], drink:true },
    { tag:"Coffee Based", name:"Avocado Coffee", price:"Rp 32.000", grad:["#7a9a5a","#3f5c2c"], drink:true },
    { tag:"Coffee Based", name:"Vietnam Drip", price:"Rp 27.000", grad:["#6b4a2c","#241713"], drink:true },
    { tag:"Coffee Based", name:"Affogato", price:"Rp 32.000", grad:["#e8d9b5","#a5764a"], drink:true },
    { tag:"Coffee Based", name:"Flat White", price:"Rp 29.000", grad:["#4a7ab5","#e8e0d0"], drink:true },
    { tag:"Coffee Based", name:"Pistachio Macchiato", price:"Rp 33.000", grad:["#8ba05a","#dbe0c0"], drink:true },
    { tag:"Non-Coffee", name:"Ice Lemon Tea", price:"Rp 15.000", grad:["#e8c14a","#f2e07a"], drink:true },
    { tag:"Non-Coffee", name:"Thai Tea", price:"Rp 18.000", grad:["#e08a3c","#b5541e"], drink:true },
    { tag:"Non-Coffee", name:"Matcha Latte", price:"Rp 17.000", grad:["#8bb35a","#4f7a2e"], drink:true },
    { tag:"Pastry", name:"Butter Croissant", price:"Rp 14.000", grad:["#e0a83c","#a5501c"], drink:false },
    { tag:"Pastry", name:"Cheese Danish", price:"Rp 16.000", grad:["#e8c96a","#c98a2e"], drink:false },
    { tag:"Pastry", name:"Sausage Roll", price:"Rp 17.000", grad:["#a5601c","#5c2f10"], drink:false },
  ];

  function drinkSVG(id, c1, c2){
    return `
    <svg viewBox="0 0 200 140" preserveAspectRatio="xMidYMid slice">
      <defs>
        <linearGradient id="g${id}" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stop-color="${c1}"/>
          <stop offset="1" stop-color="${c2}"/>
        </linearGradient>
      </defs>
      <rect width="200" height="140" fill="${c2}"/>
      <ellipse cx="100" cy="70" rx="55" ry="38" fill="url(#g${id})"/>
      <rect x="60" y="60" width="80" height="55" rx="8" fill="${c1}" opacity="0.9"/>
      <ellipse cx="100" cy="60" rx="40" ry="14" fill="${c2}" opacity="0.85"/>
    </svg>`;
  }

  function pastrySVG(id, c1, c2){
    return `
    <svg viewBox="0 0 200 140" preserveAspectRatio="xMidYMid slice">
      <defs>
        <radialGradient id="p${id}" cx="50%" cy="40%" r="70%">
          <stop offset="0" stop-color="${c1}"/>
          <stop offset="1" stop-color="${c2}"/>
        </radialGradient>
      </defs>
      <rect width="200" height="140" fill="${c2}"/>
      <ellipse cx="100" cy="75" rx="70" ry="42" fill="url(#p${id})"/>
      <path d="M50 80 Q100 40 150 80" stroke="${c2}" stroke-width="4" fill="none" opacity="0.5"/>
    </svg>`;
  }

  const grid = document.getElementById('menuGrid');
  const sectionTitle = document.getElementById('sectionTitle');
  const searchInput = document.getElementById('searchInput');

  function renderMenu(){
    const activeChip = document.querySelector('.chip.active');
    const category = activeChip ? activeChip.dataset.category : 'Semua';
    const keyword = searchInput.value.trim().toLowerCase();

    const filtered = menu.filter(item=>{
      const matchCategory = category === 'Semua' || item.tag === category;
      const matchKeyword = item.name.toLowerCase().includes(keyword);
      return matchCategory && matchKeyword;
    });

    sectionTitle.textContent = category === 'Semua' ? 'Semua Menu' : category;

    grid.innerHTML = '';
    if(filtered.length === 0){
      grid.innerHTML = `<div style="grid-column:1/-1; text-align:center; color:var(--muted); padding:30px 0; font-size:13px;">Menu tidak ditemukan</div>`;
      return;
    }
    filtered.forEach((item, i)=>{
      const card = document.createElement('div');
      card.className = 'card';
      card.innerHTML = `
        <div class="thumb">${ item.drink ? drinkSVG(i, item.grad[0], item.grad[1]) : pastrySVG(i, item.grad[0], item.grad[1]) }</div>
        <div class="card-body">
          <div class="card-tag">${item.tag}</div>
          <div class="card-name">${item.name}</div>
          <div class="card-price">${item.price}</div>
        </div>
      `;
      grid.appendChild(card);
    });
  }

  renderMenu();

  // ---- Navbar interaction ----
  const items = document.querySelectorAll('.nav-item');
  items.forEach(item=>{
    item.addEventListener('click', ()=>{
      items.forEach(i=>i.classList.remove('active'));
      item.classList.add('active');
    });
  });

  // ---- Category chip interaction ----
  const chips = document.querySelectorAll('.chip');
  chips.forEach(chip=>{
    chip.addEventListener('click', ()=>{
      chips.forEach(c=>c.classList.remove('active'));
      chip.classList.add('active');
      renderMenu();
    });
  });

  // ---- Search interaction ----
  searchInput.addEventListener('input', renderMenu);
</script>
</body>
</html>