<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Presensi | SMK Islam Krembung</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
body {
    margin:0; padding:0; height:100vh;
    background: url('{{ asset("assets/img/backsmk1.png") }}') no-repeat center center fixed;
    background-size: cover;
    display:flex; justify-content:center; align-items:center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.overlay { position:absolute; inset:0; background:rgba(0,0,0,0.25); z-index:0; }
.login-container {
    position:relative; z-index:1;
    max-width:340px; width:90%;
    background:rgba(255,255,255,0.95);
    backdrop-filter:blur(8px);
    border-radius:1rem;
    box-shadow:0 15px 35px rgba(0,0,0,0.25);
    padding:2rem 1.5rem; text-align:center;
}
.login-container img { width:80px; margin-bottom:1rem; }
.login-container h3 { margin-bottom:0.3rem; font-weight:700; font-size:1.5rem; color:#333; }
.school-name { font-size:0.95rem; font-weight:500; color:#555; margin-bottom:0.5rem; }
.form-control { border-radius:0.5rem; height:42px; }
.input-group-text { border-radius:0.5rem 0 0 0.5rem; background:#f1f1f1; border:1px solid #ddd; }
.btn-login {
    background-color:#A3E4D7; border-color:#A3E4D7; color:#333;
    font-weight:600; border-radius:0.6rem; height:42px; transition:all 0.3s ease;
}
.btn-login:hover { background-color:#79D1C3; border-color:#79D1C3; color:#333; transform:translateY(-1px); }
.footer-text { font-size:0.95rem; color:#999; margin-top:0.3rem; }
.footer-divider { height:1px; background:#ccc; margin: 0.5rem auto; width:80%; }
</style>
</head>
<body>
<div class="overlay"></div>
<div class="login-container">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SMK">
    <h3>Presensi Digital</h3>
    <p class="school-name">SMK Islam Krembung</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
        </div>
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
        </div>
        <button type="submit" class="btn btn-login w-100">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </button>
    </form>

    <div class="mt-3">
        <div class="footer-divider"></div>
        <div class="footer-text">&copy; {{ date('Y') }} SMK Islam Krembung</div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>