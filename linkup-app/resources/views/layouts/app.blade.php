<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LinkUp — Réseau Social')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:          #080C14;
            --surface:     #0F1623;
            --surface2:    #162032;
            --border:      #1E2D45;
            --border2:     #263A55;
            --accent:      #4F8EF7;
            --accent-dark: #3A72D8;
            --accent-glow: rgba(79,142,247,0.15);
            --danger:      #EF4444;
            --danger-dark: #DC2626;
            --like:        #F43F5E;
            --like-active: #FB7185;
            --success:     #10B981;
            --text:        #E2E8F0;
            --text-muted:  #64748B;
            --text-soft:   #94A3B8;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(8,12,20,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -.02em;
            text-decoration: none;
        }

        .navbar-brand span { color: var(--text); }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-user {
            font-size: .9rem;
            color: var(--text-soft);
        }

        .nav-user strong { color: var(--text); font-weight: 600; }

        .btn-logout {
            background: none;
            border: 1px solid var(--border2);
            color: var(--text-muted);
            font-family: 'Outfit', sans-serif;
            font-size: .85rem;
            padding: .35rem .9rem;
            border-radius: 6px;
            cursor: pointer;
            transition: border-color .15s, color .15s;
        }

        .btn-logout:hover { border-color: var(--danger); color: var(--danger); }

        /* ── Content wrapper ── */
        .main-wrapper {
            max-width: 640px;
            margin: 0 auto;
            padding: 2rem 1rem 4rem;
        }

        /* ── Flash messages ── */
        .flash-box {
            padding: .75rem 1.1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .flash-success { background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.3); color: var(--success); }
        .flash-error   { background: rgba(239,68,68,.10);  border: 1px solid rgba(239,68,68,.3);  color: var(--danger);  }

        /* ── Boutons utilitaires ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .55rem 1.2rem;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background .15s, transform .1s, box-shadow .15s;
            text-decoration: none;
        }

        .btn:active { transform: scale(.97); }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }
        .btn-primary:hover { background: var(--accent-dark); box-shadow: 0 4px 14px rgba(79,142,247,.3); }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border2);
            color: var(--text-soft);
        }
        .btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

        .btn-danger {
            background: transparent;
            border: 1px solid rgba(239,68,68,.4);
            color: var(--danger);
        }
        .btn-danger:hover { background: rgba(239,68,68,.1); }

        @yield('extra-styles')
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('posts.index') }}" class="navbar-brand">Link<span>Up</span></a>
    <div class="navbar-right">
        <span class="nav-user">Connecté en tant que <strong>{{ Auth::user()->name ?? '' }}</strong></span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="main-wrapper">

    @if(session('success'))
        <div class="flash-box flash-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-box flash-error">✖ {{ session('error') }}</div>
    @endif

    @yield('content')
</div>

@yield('scripts')
</body>
</html>
