<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Felújított notebookok átlátható kínálata a ReNew Kft.-től.">
    <title>@yield('title', 'ReNew | Felújított notebookok')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#182a27;--muted:#6a7773;--green:#315f4e;--paper:#f5f6f1;--line:#e5e9e2;--bs-primary:#315f4e;--bs-primary-rgb:49,95,78}
        *{box-sizing:border-box}body{margin:0;background:var(--paper);color:var(--ink);font:15px 'DM Sans',sans-serif}a{color:inherit;text-decoration:none}
        .navbar-renew{background:#182a27!important}.navbar-renew .navbar-brand{font:800 23px Manrope;color:#fff}.navbar-renew .navbar-brand em{font-style:normal;color:#c7ed70}.navbar-renew .nav-link{color:#e9eee9}.navbar-renew .nav-link:hover{color:#c7ed70}
        .page-wrap{max-width:1120px;margin:auto;padding:42px 24px 80px}.hero{background:#e8eee2;border-radius:26px;padding:66px;display:grid;grid-template-columns:1.05fr .95fr;gap:40px;align-items:center}.eyebrow{color:var(--green);font-weight:700;text-transform:uppercase;letter-spacing:.12em;font-size:12px}.hero h1{font:800 clamp(36px,5vw,60px)/1.07 Manrope;margin:18px 0}.hero p,.muted{color:var(--muted);line-height:1.7}.hero img{width:100%;height:330px;object-fit:cover;border-radius:20px}.btn-renew{display:inline-block;border:0;border-radius:99px;padding:13px 21px;background:var(--green);color:#fff;font-weight:700}.stats,.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:28px}.card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:24px}.card h3{font:700 19px Manrope}.section-title{font:800 30px Manrope;margin:46px 0 18px}.table-wrap{overflow:auto;background:white;border:1px solid var(--line);border-radius:16px}table{border-collapse:collapse;width:100%;min-width:780px}th,td{text-align:left;padding:14px 16px;border-bottom:1px solid var(--line)}th{font-size:12px;color:var(--muted);text-transform:uppercase}input,textarea,select{width:100%;padding:12px 14px;border:1px solid #d8dfd6;border-radius:10px;font:inherit;margin:6px 0 16px;background:white}label{font-weight:600}.form{max-width:620px;background:white;border:1px solid var(--line);padding:30px;border-radius:18px}.errors{color:#b42318}.success{background:#e4f4d5;padding:12px;border-radius:10px;margin-bottom:16px}.pagination{display:flex;gap:8px;justify-content:center;margin:22px}.site-footer{padding:26px;text-align:center;color:var(--muted);border-top:1px solid var(--line);background:white}
        @media(max-width:760px){.page-wrap{padding:24px 16px 56px}.hero{padding:30px;grid-template-columns:1fr}.hero img{height:230px}.grid,.stats{grid-template-columns:1fr}}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-renew">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Re<em>New</em></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#renewNav" aria-controls="renewNav" aria-expanded="false" aria-label="Navigáció megnyitása"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="renewNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Főoldal</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('notebooks.index') }}">Adatbázis</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Kapcsolat</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('chart') }}">Diagram</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('messages.index') }}">Üzenetek</a></li>
                    @if(auth()->user()->isAdmin())<li class="nav-item"><a class="nav-link" href="{{ route('admin.notebooks.index') }}">CRUD</a></li>@endif
                    <li class="nav-item"><form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light btn-sm rounded-pill px-3">Kijelentkezés</button></form></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Bejelentkezés</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm rounded-pill px-3" href="{{ route('register') }}">Regisztráció</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main class="page-wrap">
    @if(session('success'))<div class="success" role="status">{{ session('success') }}</div>@endif
    @yield('content')
</main>
<footer class="site-footer">© {{ date('Y') }} ReNew Kft. · Készítők: Jantyik Róbert (H8O0EL) · Kovács Szabolcs Péter (EBKILY)</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
