<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Ruang Seduh</title>

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

            margin-bottom:25px;

        }

        label{

            display:block;

            margin-bottom:10px;

            font-size:16px;

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

            border-color:#E76E57;

            background:white;

        }

        .btn-login{

            width:100%;

            height:58px;

            border:none;

            border-radius:40px;

            background:#2D1D1B;

            color:white;

            font-size:20px;

            font-weight:600;

            cursor:pointer;

            margin-top:18px;

            box-shadow:0 0 25px rgba(0,0,0,.25);

            transition:.3s;

        }

        .btn-login:hover{

            transform:translateY(-2px);

        }

        .bottom-text{

            text-align:center;

            margin-top:30px;

            color:#999;

        }

        .bottom-text a{

            text-decoration:none;

            color:#111;

            font-weight:700;

        }

        .error{

            background:#ffe8e8;

            color:#b10000;

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
            Masuk
        </div>

    </div>

    <div class="content">

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('customer.login.store') }}" method="POST">

            @csrf

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

            <button type="submit" class="btn-login">

                Masuk Sekarang

            </button>

        </form>

        <div class="bottom-text">

            Belum punya akun?

            <a href="{{ route('customer.register') }}">

                Daftar

            </a>

        </div>

    </div>

</div>

</body>
</html>