@extends('layouts.app')

@section('title', 'Feed — LinkUp')

@section('extra-styles')
<style>
    /* ── Composer (formulaire de post) ── */
    .composer {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.2rem 1.4rem;
        margin-bottom: 1.5rem;
    }

    .composer-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-bottom: .9rem;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), #8B5CF6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: #fff;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .avatar-sm {
        width: 34px;
        height: 34px;
        font-size: .85rem;
    }

    .composer-name {
        font-weight: 600;
        font-size: .95rem;
    }

    #post-textarea {
        width: 100%;
        background: var(--bg);
        border: 1px solid var(--border2);
        border-radius: 10px;
        color: var(--text);
        font-family: 'Outfit', sans-serif;
        font-size: .95rem;
        line-height: 1.6;
        padding: .75rem 1rem;
        resize: vertical;
        min-height: 80px;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }

    #post-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    #post-textarea::placeholder { color: var(--text-muted); }

    .composer-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: .8rem;
    }

    .char-counter {
        font-size: .8rem;
        color: var(--text-muted);
        transition: color .15s;
    }

    .char-counter.warning { color: #F59E0B; }
    .char-counter.danger  { color: var(--danger); }

    #composer-error {
        color: var(--danger);
        font-size: .82rem;
        margin-top: .4rem;
        display: none;
    }

    /* ── Section titre feed ── */
    .feed-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .feed-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-soft);
    }

    /* ── Cards de posts ── */
    .post-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.2rem 1.4rem;
        margin-bottom: 1rem;
        transition: border-color .2s;
        animation: slideIn .25s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0);     }
    }

    .post-card:hover { border-color: var(--border2); }

    .post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .8rem;
    }

    .post-author {
        display: flex;
        align-items: center;
        gap: .65rem;
    }

    .post-author-name {
        font-weight: 600;
        font-size: .95rem;
    }

    .post-author-name .you-badge {
        font-size: .7rem;
        font-weight: 500;
        background: var(--accent-glow);
        color: var(--accent);
        border: 1px solid rgba(79,142,247,.3);
        padding: .1rem .45rem;
        border-radius: 999px;
        margin-left: .4rem;
        vertical-align: middle;
    }

    .post-date {
        font-size: .78rem;
        color: var(--text-muted);
        margin-top: .05rem;
    }

    .post-actions-owner {
        display: flex;
        gap: .5rem;
    }

    .btn-icon {
        background: none;
        border: 1px solid var(--border2);
        color: var(--text-muted);
        width: 30px;
        height: 30px;
        border-radius: 7px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
        transition: all .15s;
        text-decoration: none;
    }

    .btn-icon:hover { color: var(--accent); border-color: var(--accent); }
    .btn-icon.del:hover { color: var(--danger); border-color: var(--danger); }

    .post-body {
        font-size: 1rem;
        line-height: 1.65;
        color: var(--text);
        margin-bottom: 1rem;
        white-space: pre-wrap;
        word-break: break-word;
    }

    .post-footer {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding-top: .75rem;
        border-top: 1px solid var(--border);
    }

    /* ── Bouton Like ── */
    .btn-like {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: none;
        border: 1px solid var(--border2);
        border-radius: 999px;
        color: var(--text-muted);
        font-family: 'Outfit', sans-serif;
        font-size: .88rem;
        font-weight: 500;
        padding: .3rem .85rem;
        cursor: pointer;
        transition: all .2s;
        user-select: none;
    }

    .btn-like:hover {
        border-color: var(--like);
        color: var(--like);
        background: rgba(244,63,94,.07);
    }

    .btn-like.liked {
        border-color: var(--like);
        color: var(--like);
        background: rgba(244,63,94,.1);
    }

    .btn-like .heart { font-size: 1rem; transition: transform .2s; }
    .btn-like.liked .heart { animation: pop .25s ease; }

    @keyframes pop {
        0%   { transform: scale(1); }
        50%  { transform: scale(1.4); }
        100% { transform: scale(1); }
    }

    /* Vide */
    .feed-empty {
        text-align: center;
        padding: 3rem 0;
        color: var(--text-muted);
    }

    .feed-empty .empty-icon { font-size: 2.5rem; margin-bottom: .75rem; }
    .feed-empty p { font-size: .95rem; }

    /* Skeleton loader (post en cours de suppression) */
    .post-card.removing {
        opacity: 0;
        transform: scale(.97);
        transition: opacity .25s, transform .25s;
    }
</style>
@endsection

@section('content')

{{-- ── Composer ── --}}
<div class="composer">
    <div class="composer-header">
        <div class="avatar">{{ substr($currentUser->name, 0, 1) }}</div>
        <span class="composer-name">{{ $currentUser->name }}</span>
    </div>

    <textarea id="post-textarea" placeholder="Quoi de neuf ? Exprime-toi…" maxlength="500" rows="3"></textarea>
    <p id="composer-error"></p>

    <div class="composer-footer">
        <span class="char-counter"><span id="char-count">0</span> / 500</span>
        <button class="btn btn-primary" id="btn-publish" onclick="publishPost()">
            <span>✦</span> Publier
        </button>
    </div>
</div>

{{-- ── Feed ── --}}
<div class="feed-header">
    <span class="feed-title">Tous les posts</span>
</div>

<div id="feed">
    @forelse($posts as $post)
        <div class="post-card" id="post-{{ $post->id }}">
            <div class="post-header">
                <div class="post-author">
                    <div class="avatar avatar-sm">{{ substr($post->user->name, 0, 1) }}</div>
                    <div>
                        <div class="post-author-name">
                            {{ $post->user->name }}
                            @if($post->user_id === $currentUser->id)
                                <span class="you-badge">Vous</span>
                            @endif
                        </div>
                        <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                @if($post->user_id === $currentUser->id)
                    <div class="post-actions-owner">
                        <a href="{{ route('posts.edit', $post) }}" class="btn-icon" title="Modifier">✎</a>
                        <button class="btn-icon del" title="Supprimer"
                                onclick="deletePost({{ $post->id }})">✕</button>
                    </div>
                @endif
            </div>

            <div class="post-body">{{ $post->contenu }}</div>

            <div class="post-footer">
                <button
                    class="btn-like {{ $post->liked ? 'liked' : '' }}"
                    id="like-btn-{{ $post->id }}"
                    onclick="toggleLike({{ $post->id }})"
                >
                    <span class="heart">{{ $post->liked ? '♥' : '♡' }}</span>
                    <span id="like-count-{{ $post->id }}">{{ $post->likesCount }}</span>
                </button>
            </div>
        </div>
    @empty
        <div class="feed-empty" id="empty-state">
            <div class="empty-icon">✦</div>
            <p>Aucun post pour l'instant.<br>Sois le premier à publier !</p>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
    const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
    const ME_ID  = {{ $currentUser->id }};
    const ME_NAME= @json($currentUser->name);

    // ── Compteur de caractères ────────────────────────────────────
    const textarea  = document.getElementById('post-textarea');
    const counter   = document.getElementById('char-count');
    const counterBox= counter.parentElement;

    textarea.addEventListener('input', () => {
        const len = textarea.value.length;
        counter.textContent = len;
        counterBox.className = 'char-counter' +
            (len >= 480 ? ' danger' : len >= 400 ? ' warning' : '');
    });

    // ── Publier un post (AJAX) ────────────────────────────────────
    async function publishPost() {
        const btn     = document.getElementById('btn-publish');
        const errBox  = document.getElementById('composer-error');
        const contenu = textarea.value.trim();

        errBox.style.display = 'none';

        if (!contenu) {
            errBox.textContent = 'Le contenu ne peut pas être vide.';
            errBox.style.display = 'block';
            return;
        }

        btn.disabled = true;
        btn.textContent = '…';

        try {
            const res  = await fetch('{{ route("posts.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ contenu }),
            });

            const data = await res.json();

            if (data.success) {
                textarea.value = '';
                counter.textContent = '0';
                counterBox.className = 'char-counter';
                prependPost(data.post);
                // Retirer l'état vide si présent
                const empty = document.getElementById('empty-state');
                if (empty) empty.remove();
            } else {
                errBox.textContent = data.message ?? 'Erreur lors de la publication.';
                errBox.style.display = 'block';
            }
        } catch (e) {
            errBox.textContent = 'Erreur réseau. Réessayez.';
            errBox.style.display = 'block';
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>✦</span> Publier';
        }
    }

    // ── Insérer un post en haut du feed ──────────────────────────
    function prependPost(post) {
        const isOwner = post.user_id === ME_ID;
        const card = document.createElement('div');
        card.className = 'post-card';
        card.id = `post-${post.id}`;
        card.innerHTML = `
            <div class="post-header">
                <div class="post-author">
                    <div class="avatar avatar-sm">${post.user_name[0].toUpperCase()}</div>
                    <div>
                        <div class="post-author-name">
                            ${escHtml(post.user_name)}
                            ${isOwner ? '<span class="you-badge">Vous</span>' : ''}
                        </div>
                        <div class="post-date">${escHtml(post.created_at)}</div>
                    </div>
                </div>
                ${isOwner ? `
                <div class="post-actions-owner">
                    <a href="/posts/${post.id}/edit" class="btn-icon" title="Modifier">✎</a>
                    <button class="btn-icon del" title="Supprimer"
                            onclick="deletePost(${post.id})">✕</button>
                </div>` : ''}
            </div>
            <div class="post-body">${escHtml(post.contenu)}</div>
            <div class="post-footer">
                <button class="btn-like" id="like-btn-${post.id}"
                        onclick="toggleLike(${post.id})">
                    <span class="heart">♡</span>
                    <span id="like-count-${post.id}">0</span>
                </button>
            </div>
        `;
        document.getElementById('feed').prepend(card);
    }

    // ── Supprimer un post (AJAX) ──────────────────────────────────
    async function deletePost(postId) {
        if (!confirm('Supprimer ce post définitivement ?')) return;

        const card = document.getElementById(`post-${postId}`);
        card.classList.add('removing');

        try {
            const res = await fetch(`/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
            });

            const data = await res.json();

            if (data.success) {
                setTimeout(() => {
                    card.remove();
                    if (!document.querySelector('.post-card')) {
                        document.getElementById('feed').innerHTML = `
                            <div class="feed-empty" id="empty-state">
                                <div class="empty-icon">✦</div>
                                <p>Aucun post pour l'instant.<br>Sois le premier à publier !</p>
                            </div>`;
                    }
                }, 250);
            } else {
                card.classList.remove('removing');
                alert('Erreur lors de la suppression.');
            }
        } catch (e) {
            card.classList.remove('removing');
            alert('Erreur réseau.');
        }
    }

    // ── Liker/Unliker un post (AJAX) ─────────────────────────────
    async function toggleLike(postId) {
        const btn   = document.getElementById(`like-btn-${postId}`);
        const heart = btn.querySelector('.heart');
        const count = document.getElementById(`like-count-${postId}`);

        btn.disabled = true;

        try {
            const res  = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
            });

            const data = await res.json();

            if (data.success) {
                btn.classList.toggle('liked', data.liked);
                heart.textContent = data.liked ? '♥' : '♡';
                count.textContent = data.count;
                // Déclencher l'animation pop
                if (data.liked) {
                    heart.classList.remove('pop');
                    void heart.offsetWidth;
                }
            }
        } catch (e) {
            console.error('Erreur like:', e);
        } finally {
            btn.disabled = false;
        }
    }

    // ── Utilitaire anti-XSS ──────────────────────────────────────
    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ── Publier avec Ctrl+Enter ───────────────────────────────────
    textarea.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') publishPost();
    });
</script>
@endsection
