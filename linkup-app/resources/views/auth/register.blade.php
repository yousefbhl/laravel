<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — LinkUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #080C14; --surface: #0F1623; --border: #1E2D45; --border2: #263A55;
            --accent: #4F8EF7; --accent-dark: #3A72D8; --danger: #EF4444;
            --text: #E2E8F0; --text-muted: #64748B; --text-soft: #94A3B8;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }
        .auth-logo { font-size: 1.8rem; font-weight: 700; color: var(--accent); text-align: center; margin-bottom: .3rem; letter-spacing: -.02em; }
        .auth-logo span { color: var(--text); }
        .auth-tagline { text-align: center; color: var(--text-muted); font-size: .9rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.1rem; }
        label { display: block; font-size: .85rem; font-weight: 500; color: var(--text-soft); margin-bottom: .4rem; }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%; background: var(--bg); border: 1px solid var(--border2); border-radius: 8px;
            color: var(--text); font-family: 'Outfit', sans-serif; font-size: .95rem;
            padding: .65rem .9rem; outline: none; transition: border-color .15s, box-shadow .15s;
        }
        input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(79,142,247,.15); }
        .field-error { color: var(--danger); font-size: .8rem; margin-top: .3rem; }
        .btn-submit {
            width: 100%; background: var(--accent); color: #fff; border: none; border-radius: 8px;
            font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 600; padding: .7rem;
            cursor: pointer; margin-top: .5rem; transition: background .15s, box-shadow .15s;
        }
        .btn-submit:hover { background: var(--accent-dark); box-shadow: 0 4px 14px rgba(79,142,247,.3); }
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: .88rem; color: var(--text-muted); }
        .auth-footer a { color: var(--accent); text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .hint { font-size: .78rem; color: var(--text-muted); margin-top: .25rem; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">Link<span>Up</span></div>
    <p class="auth-tagline">Créez votre compte gratuitement</p>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nom d'affichage</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   placeholder="Youssef Bahloul"
                   autocomplete="name">
            @error('name')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="exemple@email.com"
                   autocomplete="email">
            @error('email')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password"
                   placeholder="Minimum 6 caractères"
                   autocomplete="new-password">
            @error('password')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="••••••••"
                   autocomplete="new-password">
        </div>

        <button type="submit" class="btn-submit">Créer mon compte</button>
    </form>

    <p class="auth-footer">
        Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
    </p>
</div>
</body>
</html>
