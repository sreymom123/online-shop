<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f0f0e8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e6de;
            padding: 40px 36px 36px;
            width: 360px;
        }

        .login-title {
            font-size: 26px;
            font-weight: 700;
            color: #1e3a2b;
            text-align: center;
            margin-bottom: 6px;
            letter-spacing: -.4px;
        }

        .login-sub {
            font-size: 13px;
            color: #7a8c80;
            text-align: center;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .login-sub span { color: #2d7a45; font-weight: 500; }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #1e3a2b;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 16px;
        }

        .input-wrap i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0b0a8;
            font-size: 14px;
        }

        .input-wrap input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1px solid #e2e6de;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: #f7f8f5;
            color: #1a2e1f;
            outline: none;
            transition: border-color .15s, background .15s;
        }

        .input-wrap input::placeholder { color: #b0bcb4; }
        .input-wrap input:focus {
            border-color: #5a8a6a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(90,138,106,.12);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #1e3a2b;
            color: #fff;
            border: none;
            border-radius: 99px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 6px;
            transition: background .15s;
            letter-spacing: .1px;
        }
        .btn-login:hover { background: #2d5a3d; }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #7a8c80;
            text-decoration: none;
        }
        .forgot-link span { color: #2d7a45; }
        .forgot-link:hover { color: #1e3a2b; }

        .alert-danger {
            background: #fdf0f0;
            border: 1px solid #f5c0c0;
            color: #8a2020;
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 18px;
        }

        .alert-success {
            background: #e6f4ec;
            border: 1px solid #b0d9bc;
            color: #1e3a2b;
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 14px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1 class="login-title">Admin Login</h1>
        <p class="login-sub">Welcome back to the <span>admin page</span></p>

        @if($errors->any())
            <div class="alert-danger">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-1">
                <label class="form-label">Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email"
                           placeholder="name@organicharvest.com"
                           value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="mb-1">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password"
                           placeholder="••••••••" required>
                </div>
            </div>
            <button class="btn-login">Login →</button>
        </form>

        <a href="#" class="forgot-link">Forgot <span>your credentials</span>?</a>
    </div>
</body>
</html>
