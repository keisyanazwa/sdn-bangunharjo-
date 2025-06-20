<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SDN Bangunharjo</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/front_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-logo img {
            height: 80px;
            margin-bottom: 10px;
        }
        .login-title {
            color: #fff;
            font-weight: bold;
            font-size: 1.8rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            letter-spacing: 1px;
            text-align: center;
        }
        .login-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .login-header {
            background: #2a5298;
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .login-body {
            padding: 30px;
            background: white;
        }
        .form-group label {
            font-weight: 500;
            color: #2a5298;
        }
        .btn-login {
            background: #2a5298;
            border-color: #2a5298;
            font-weight: 500;
            padding: 10px 20px;
            width: 100%;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: #1e3c72;
            border-color: #1e3c72;
        }
        .login-btn {
            background: #2a5298;
            border: none;
            border-radius: 30px;
            padding: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(42, 82, 152, 0.3);
            transition: all 0.3s;
        }
        .login-btn:hover {
            background: #1a4188;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(42, 82, 152, 0.4);
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
             border-color: #2a5298;
             box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.2);
         }
         body {
             background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
             min-height: 100vh;
         }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #fff;
            font-size: 0.9rem;
        }
        .login-footer a {
            color: #fff;
            text-decoration: underline;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
     </style>
 </head>
 <body>
    <div class="container login-container">
        <div class="login-logo">
            <img src="{{ asset('images/front_logo.png') }}" alt="Logo SDN Bangunharjo">
            <h2 class="login-title">SD NEGERI BANGUNHARJO</h2>
        </div>
        <div class="login-card">
            <div class="login-header">
                <i class="bi bi-shield-lock"></i> Login Admin
            </div>
            <div class="login-body">
                <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label><i class="bi bi-person"></i> Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label><i class="bi bi-key"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block login-btn">MASUK <i class="bi bi-arrow-right"></i></button>
                    @if($errors->any())
                    <div class="text-danger mt-3 text-center">
                        <i class="bi bi-exclamation-triangle"></i> {{ $errors->first('message') }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
        
        <div class="login-footer">
            <p>&copy; {{ date('Y') }} SD Negeri Bangunharjo. All Rights Reserved.</p>
            <p><a href="{{ route('pages.home') }}">Kembali ke Halaman Utama</a></p>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>