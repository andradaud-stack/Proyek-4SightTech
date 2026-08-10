<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Seduh</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            display:flex;
    justify-content:center;
    align-items:center;
    background:#2D1D1B;
        }

        .phone{

            width:100%;
    max-width:390px;
    min-height:100vh;
    background:#2D1D1B;
    position:relative;
    overflow:hidden;

        }

        .top{

            background:#6B4433;
            min-height:45vh;
            border-bottom-left-radius:50% 18%;
            border-bottom-right-radius:50% 18%;

            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;

        }

        .logo{

            width:60%;
    max-width:220px;

        }

        .bottom{

            padding:45px;

        }

        h1{

            color:white;
            font-size:clamp(28px,4vw,40px);
            line-height:40px;
            font-weight:700;
            margin-bottom:55px;

        }

        .btn-login{

            display:block;
            width:100%;
            padding:16px 20px;
            border-radius:50px;
            text-align:center;
            text-decoration:none;
            background:#E76E57;
            color:white;
            font-size:20px;
            font-weight:600;

            box-shadow:0 0 35px rgba(231,110,87,.6);

            margin-bottom:22px;

            transition:.3s;

        }

        .btn-login:hover{

            transform:translateY(-3px);

        }

        .btn-register{

            display:block;
            width:100%;
            padding:16px 20px;
            border-radius:50px;
            border:2px solid white;
            text-align:center;
            text-decoration:none;
            color:white;
            font-size:20px;
            font-weight:600;

            transition:.3s;

        }

        .btn-register:hover{

            background:white;
            color:#2D1D1B;

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

    </div>

    <div class="bottom">

        <h1>
            Tempat Singgah<br>
            Sebelum Melangkah
        </h1>

        <a href="{{ route('customer.login') }}"
           class="btn-login">

            Masuk

        </a>

        <a href="{{ route('customer.register') }}"
           class="btn-register">

            Daftar Akun Baru

        </a>

    </div>

</div>

</body>
</html>