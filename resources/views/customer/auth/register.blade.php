<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Ruang Seduh</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#2D1D1B;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }

        .phone{
            width:100%;
            max-width:390px;
            min-height:100vh;
            background:#2D1D1B;
            overflow:hidden;
        }

        .top{

            background:#6B4433;
            height:38vh;
            min-height:280px;

            border-bottom-left-radius:50% 18%;
            border-bottom-right-radius:50% 18%;

            position:relative;

            display:flex;
            justify-content:center;
            align-items:center;

        }

        .logo{

            position:absolute;
            top:25px;
            left:25px;
            width:70px;

        }

        .title{

            color:white;
            font-size:52px;
            font-weight:700;

        }

        .content{

            background:white;

            margin-top:-30px;

            border-radius:35px 35px 0 0;

            padding:40px 28px;

            min-height:62vh;

        }

        .form-group{

            margin-bottom:22px;

        }

        label{

            display:block;

            margin-bottom:8px;

            font-size:15px;

            font-weight:700;

            color:#111;

        }

        input{

            width:100%;

            height:52px;

            border-radius:16px;

            border:1px solid #ddd;

            background:#efefef;

            padding:0 18px;

            font-size:15px;

            outline:none;

        }

        input:focus{

            background:white;

            border-color:#E76E57;

        }

        .btn-register{

            width:100%;

            height:58px;

            border:none;

            border-radius:40px;

            background:#2D1D1B;

            color:white;

            font-size:20px;

            font-weight:600;

            cursor:pointer;

            margin-top:20px;

            box-shadow:0 0 25px rgba(0,0,0,.25);

            transition:.3s;

        }

        .btn-register:hover{

            transform:translateY(-2px);

        }

        .bottom-text{

            margin-top:30px;

            text-align:center;

            color:#999;

        }

        .bottom-text a{

            text-decoration:none;

            color:#111;

            font-weight:700;

        }

        .error{

            background:#FFE8E8;

            color:#C62828;

            padding:12px;

            border-radius:12px;

            margin-bottom:20px;

        }

    </style>

</head>

<body>

<div class="phone">

    <div class="top">

        <img
            src="{{ asset('assets/images/LOGO_RUANG_SEDUH(putih).png') }}"
            class="logo"
            alt="Logo">

        <div class="title">
            Daftar
        </div>

    </div>

    <div class="content">

        @if ($errors->any())

            <div class="error">
                <ul style="padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <form action="{{ route('customer.register.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}"
                    required>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required>

            </div>

            <div class="form-group">

                <label>Konfirmasi Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required>

            </div>

            <button type="submit" class="btn-register">

                Daftar Sekarang

            </button>

        </form>

        <div class="bottom-text">

            Sudah punya akun?

            <a href="{{ route('customer.login') }}">

                Masuk

            </a>

        </div>

    </div>

</div>

</body>
</html>