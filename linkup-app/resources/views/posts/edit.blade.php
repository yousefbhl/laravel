@extends('layouts.app')

@section('title', 'Modifier le post — LinkUp')

@section('extra-styles')
<style>
    .edit-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 2rem;
    }

    .edit-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text);
    }

    .edit-title span { color: var(--accent); }

    .form-group { margin-bottom: 1.2rem; }

    label {
        display: block;
        font-size: .85rem;
        font-weight: 500;
        color: var(--text-soft);
        margin-bottom: .5rem;
    }

    textarea {
        width: 100%;
        background: var(--bg);
        border: 1px solid var(--border2);
        border-radius: 10px;
        color: var(--text);
        font-family: 'Outfit', sans-serif;
        font-size: .98rem;
        line-height: 1.65;
        padding: .8rem 1rem;
        resize: vertical;
        min-height: 130px;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }

    textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .field-error { color: var(--danger); font-size: .8rem; margin-top: .3rem; }

    .char-info {
        font-size: .8rem;
        color: var(--text-muted);
        text-align: right;
        margin-top: .3rem;
    }

    .edit-actions {
        display: flex;
        gap: .75rem;
        justify-content: flex-end;
        margin-top: 1rem;
    }
</style>
@endsection

@section('content')
<div class="edit-card">
    <p class="edit-title">✎ Modifier le <span>post</span></p>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="contenu">Contenu</label>
            <textarea id="contenu" name="contenu"
                      maxlength="500"
                      rows="5">{{ old('contenu', $post->contenu) }}</textarea>
            <div class="char-info">
                <span id="char-count">{{ strlen(old('contenu', $post->contenu)) }}</span> / 500
            </div>
            @error('contenu')<p class="field-error">{{ $message }}</p>@enderror
        </div>

        <div class="edit-actions">
            <a href="{{ route('posts.index') }}" class="btn btn-ghost">Annuler</a>
            <button type="submit" class="btn btn-primary">✦ Sauvegarder</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const ta = document.getElementById('contenu');
    const cc = document.getElementById('char-count');
    ta.addEventListener('input', () => cc.textContent = ta.value.length);
</script>
@endsection
