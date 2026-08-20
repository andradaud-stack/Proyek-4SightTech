<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Ubah Profil - Ruang Seduh</title>
<style>
  :root{
    --accent: #e07a5f;
    --dark: #141414;
    --muted: #8a7565;
    --cream: #f6ece3;
    --field: #ece0d2;
  }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #111;
  }
  .ep-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: linear-gradient(180deg, #241814 0%, #17110f 140px, var(--cream) 140px);
    position:relative;
    overflow-x:hidden;
  }

  .ep-header{
    display:flex;
    align-items:center;
    gap:14px;
    padding:44px 20px 46px;
  }
  .ep-back{
    width:36px;
    height:36px;
    border-radius:50%;
    background:rgba(255,255,255,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:#fff;
    flex-shrink:0;
  }
  .ep-back svg{ width:16px; height:16px; stroke:currentColor; stroke-width:2.4; fill:none; }
  .ep-header h1{
    color:#fff;
    font-size:22px;
    font-weight:800;
    margin:0;
  }

  .ep-card{
    background:var(--cream);
    border-radius:32px 32px 0 0;
    margin-top:-30px;
    padding:32px 24px 40px;
    min-height:calc(100dvh - 140px);
  }

  .ep-field{ margin-bottom:22px; }
  .ep-label{
    display:block;
    font-size:12px;
    font-weight:800;
    letter-spacing:.03em;
    text-transform:uppercase;
    color:var(--muted);
    margin-bottom:10px;
  }
  .ep-input{
    width:100%;
    border:none;
    outline:none;
    background:var(--field);
    border-radius:14px;
    padding:16px 18px;
    font-size:15px;
    color:var(--dark);
  }
  .ep-input::placeholder{ color:#a89a89; }

  .ep-error{
    color:#c0392b;
    font-size:12px;
    margin-top:6px;
  }

  .ep-submit{
    width:100%;
    border:none;
    background:var(--dark);
    color:#fff;
    font-size:15px;
    font-weight:700;
    padding:17px 0;
    border-radius:999px;
    cursor:pointer;
    margin-top:14px;
    box-shadow:0 10px 25px rgba(20,20,20,.25);
  }
  .ep-submit:active{ opacity:0.85; }

  @media (min-width:700px){
    .ep-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

<div class="ep-wrap">

  <div class="ep-header">
    <a href="{{ route('customer.profile.index') }}" class="ep-back" aria-label="Kembali">
      <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <h1>Ubah Profil</h1>
  </div>

  <div class="ep-card">
    <form action="{{ route('customer.profile.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="ep-field">
        <label class="ep-label" for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" class="ep-input"
               value="{{ old('name', $user->name ?? '') }}" required>
        @error('name')
          <div class="ep-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="ep-field">
        <label class="ep-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="ep-input"
               value="{{ old('email', $user->email ?? '') }}" required>
        @error('email')
          <div class="ep-error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="ep-submit">Simpan Perubahan</button>
    </form>
  </div>

</div>
</body>
</html>