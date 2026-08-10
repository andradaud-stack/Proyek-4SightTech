@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: #f6f7fb;
            color: #1f2430;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        }

        .auth-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }

        .auth-brand .logo {
            width: 40px; height: 40px;
            background: #4f46e5; color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 18px;
            border-radius: 10px;
        }

        .auth-brand h1 { font-size: 20px; font-weight: 700; }

        .auth-eyebrow {
            text-transform: uppercase; letter-spacing: .12em;
            font-size: 12px; font-weight: 600; color: #4f46e5; margin-bottom: 6px;
        }

        .auth-title { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        .auth-subtitle { font-size: 14px; color: #64748b; margin-bottom: 24px; }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;
        }

        .form-group input {
            width: 100%; padding: 11px 14px;
            border: 1px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; font-family: inherit;
            background: #f8fafc;
            outline: none; transition: border-color .15s;
        }

        .form-group input:focus { border-color: #4f46e5; background: #fff; }

        .form-error { color: #dc2626; font-size: 12px; margin-top: 6px; }
        .form-alert { color: #16a34a; font-size: 13px; margin-bottom: 16px; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 100%; padding: 12px;
            background: #4f46e5; color: #fff;
            border: 0; border-radius: 10px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: background .15s;
        }

        .btn:hover { background: #4338ca; }

        .auth-footer { margin-top: 18px; font-size: 14px; text-align: center; color: #64748b; }
        .auth-footer a { color: #4f46e5; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }

        .form-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 13px; }
        .form-row label { display: flex; align-items: center; gap: 6px; font-weight: 400; cursor: pointer; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-brand">
            <span class="logo">S</span>
            <h1>{{ config('app.name') }}</h1>
        </div>
        {{ $slot }}
    </div>
</body>
</html>
