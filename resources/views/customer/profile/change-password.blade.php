<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Ubah Kata Sandi - Ruang Seduh</title>
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
  .cp-wrap{
    max-width:480px;
    margin:0 auto;
    min-height:100dvh;
    background: linear-gradient(180deg, #241814 0%, #17110f 140px, var(--cream) 140px);
    position:relative;
    overflow-x:hidden;
  }

  .cp-header{
    display:flex;
    align-items:center;
    gap:14px;
    padding:44px 20px 46px;
  }
  .cp-back{
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
  .cp-back svg{ width:16px; height:16px; stroke:currentColor; stroke-width:2.4; fill:none; }
  .cp-header h1{
    color:#fff;
    font-size:22px;
    font-weight:800;
    margin:0;
  }

  .cp-card{
    background:var(--cream);
    border-radius:32px 32px 0 0;
    margin-top:-30px;
    padding:32px 24px 40px;
    min-height:calc(100dvh - 140px);
  }

  .cp-alert{
    background:rgba(224,122,95,.15);
    border:1px solid var(--accent);
    color:var(--accent);
    font-size:13px;
    font-weight:600;
    border-radius:12px;
    padding:12px 16px;
    margin-bottom:20px;
  }

  .cp-field{ margin-bottom:22px; }
  .cp-label{
    display:block;
    font-size:12px;
    font-weight:800;
    letter-spacing:.03em;
    text-transform:uppercase;
    color:var(--muted);
    margin-bottom:10px;
  }
  .cp-input{
    width:100%;
    border:none;
    outline:none;
    background:var(--field);
    border-radius:14px;
    padding:16px 18px;
    font-size:15px;
    color:var(--dark);
    letter-spacing:.05em;
  }
  .cp-input::placeholder{ color:#a89a89; letter-spacing:normal; }

  .cp-error{
    color:#c0392b;
    font-size:12px;
    margin-top:6px;
  }

  .cp-submit{
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
  .cp-submit:active{ opacity:0.85; }

  @media (min-width:700px){
    .cp-wrap{ margin-top:24px; margin-bottom:24px; border-radius:28px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.4); }
  }
</style>
</head>
<body>

<div class="cp-wrap">

  <div class="cp-header">
    <a href="{{ route('customer.profile.index') }}" class="cp-back" aria-label="Kembali">
      <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <h1>Ubah Kata Sandi</h1>
  </div>

  <div class="cp-card">
    @if(session('message_success'))
      <div class="cp-alert">{{ session('message_success') }}</div>
    @endif

    <form action="{{ route('customer.password.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="cp-field">
        <label class="cp-label" for="current_password">Kata Sandi Lama</label>
        <input type="password" id="current_password" name="current_password" class="cp-input" placeholder="•••••••" required>
        @error('current_password')
          <div class="cp-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="cp-field">
        <label class="cp-label" for="password">Kata Sandi Baru</label>
        <input type="password" id="password" name="password" class="cp-input" placeholder="•••••••" required>
        @error('password')
          <div class="cp-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="cp-field">
        <label class="cp-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="cp-input" placeholder="•••••••" required>
      </div>

      <button type="submit" class="cp-submit">Simpan Kata Sandi</button>
    </form>
  </div>

</div>
</body>
</html>