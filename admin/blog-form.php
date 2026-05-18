<?php
require_once __DIR__ . '/layout/header.php';

$message = '';
$isEdit  = isset($_GET['id']) && is_numeric($_GET['id']);
$id      = $isEdit ? (int)$_GET['id'] : null;

$categories = ['Technology','Business','Industry News','Tutorial','Case Study','Product Update','Insights'];

$blog = [
    'title'         => '',
    'slug'          => '',
    'content'       => '',
    'feature_image' => '',
    'status'        => 'draft',
    'keywords'      => '',
    'category'      => '',
    'read_time'     => '',
];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM blogs WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $blog = array_merge($blog, $existing);
    } else {
        $isEdit = false; $id = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        csrf_fail();
    }
    $rawCategory = $_POST['category'] ?? '';
    $customCat   = trim($_POST['category_custom'] ?? '');
    $finalCat    = ($rawCategory === 'custom' && $customCat !== '') ? $customCat : $rawCategory;

    $blog = [
        'title'         => trim($_POST['title']         ?? ''),
        'slug'          => trim($_POST['slug']          ?? ''),
        'content'       => $_POST['content']            ?? '',
        'feature_image' => trim($_POST['feature_image'] ?? ''),
        'status'        => in_array($_POST['status'] ?? '', ['draft','published']) ? $_POST['status'] : 'draft',
        'keywords'      => trim($_POST['keywords']      ?? ''),
        'category'      => $finalCat,
        'read_time'     => is_numeric($_POST['read_time'] ?? '') ? max(1,(int)$_POST['read_time']) : null,
    ];

    try {
        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE blogs SET title=?,slug=?,content=?,feature_image=?,status=?,keywords=?,category=?,read_time=?,updated_at=NOW() WHERE id=?');
            $stmt->execute([$blog['title'],$blog['slug'],$blog['content'],$blog['feature_image'],
                            $blog['status'],$blog['keywords'],$blog['category'],$blog['read_time'],$id]);
            $message = '<div class="alert alert-success">Blog post updated successfully.</div>';
        } else {
            $stmt = $pdo->prepare('INSERT INTO blogs (title,slug,content,feature_image,status,keywords,category,read_time) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->execute([$blog['title'],$blog['slug'],$blog['content'],$blog['feature_image'],
                            $blog['status'],$blog['keywords'],$blog['category'],$blog['read_time']]);
            $id     = (int)$pdo->lastInsertId();
            $isEdit = true;
            $message = '<div class="alert alert-success">Blog post created successfully.</div>';
        }
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error saving: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

$statusVal   = htmlspecialchars($blog['status']);
$isCustomCat = !empty($blog['category']) && !in_array($blog['category'], $categories);
?>

<!-- ═══════════════════════════════════════════
     BLOG FORM — Extra Styles
═══════════════════════════════════════════ -->
<style>
/* ── Layout ─────────────────────────────────── */
.blog-editor-wrap  { display:grid; grid-template-columns:1fr 310px; gap:24px; align-items:start; }
.blog-editor-main  {}
.blog-editor-side  { position:sticky; top:24px; display:flex; flex-direction:column; gap:16px; }

/* ── Sidebar cards ──────────────────────────── */
.sc {
    background:var(--surface-1);
    border-radius:8px;
    box-shadow:0 1px 3px rgba(0,0,0,.1);
    overflow:hidden;
}
.sc-head {
    padding:11px 16px;
    background:var(--surface-2);
    border-bottom:1px solid var(--border);
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:var(--text-2);
    display:flex;
    align-items:center;
    gap:7px;
}
.sc-body { padding:16px; display:flex; flex-direction:column; gap:12px; }

/* ── Status toggle ──────────────────────────── */
.status-toggle { display:flex; gap:8px; }
.stbtn {
    flex:1; padding:8px 10px;
    border:2px solid var(--border);
    border-radius:6px; background:var(--surface-2);
    cursor:pointer; font-size:13px; font-weight:600;
    text-align:center; transition:all .2s; color:var(--text-2);
}
.stbtn.active[data-val="draft"]     { border-color:#f59e0b; background:#fffbeb; color:#92400e; }
.stbtn.active[data-val="published"] { border-color:#22c55e; background:#f0fdf4; color:#15803d; }

/* ── Keyword tag input ──────────────────────── */
.tag-wrap {
    border:1px solid var(--border); border-radius:4px;
    padding:6px 8px; min-height:42px;
    display:flex; flex-wrap:wrap; gap:5px; align-items:center;
    cursor:text; background:white; transition:border-color .2s;
}
.tag-wrap:focus-within { border-color:var(--accent); }
.tag-pill {
    display:inline-flex; align-items:center; gap:3px;
    background:#e0f2fe; color:#0369a1;
    border-radius:4px; padding:3px 7px;
    font-size:12px; font-weight:500;
}
.tag-pill button {
    background:none; border:none; cursor:pointer;
    padding:0 1px; color:#0369a1; font-size:15px;
    line-height:1; opacity:.6; transition:opacity .15s;
}
.tag-pill button:hover { opacity:1; }
.tag-text {
    border:none; outline:none; font-size:13px;
    min-width:80px; flex:1; font-family:inherit; background:transparent;
}

/* ── Read time ──────────────────────────────── */
.rt-badge {
    display:inline-flex; align-items:center; gap:7px;
    background:var(--surface-2); border:1px solid var(--border);
    border-radius:20px; padding:6px 13px;
    font-size:13px; font-weight:500; color:var(--text-2);
}
.rt-badge svg { color:var(--accent); }
.rt-row { display:flex; align-items:center; justify-content:space-between; }
.rt-override { display:none; gap:8px; align-items:center; margin-top:6px; }
.rt-override.on { display:flex; }
.rt-override input {
    width:56px; padding:6px 8px;
    border:1px solid var(--border); border-radius:4px;
    font-size:13px; text-align:center;
}
.link-btn {
    background:none; border:none; color:var(--accent);
    cursor:pointer; font-size:11px; padding:0; text-decoration:underline;
}

/* ── Listen / Speech ────────────────────────── */
.listen-btn {
    display:flex; align-items:center; justify-content:center; gap:8px;
    padding:10px 14px; border:2px solid var(--accent);
    border-radius:8px; background:white; color:var(--accent);
    cursor:pointer; font-size:14px; font-weight:600;
    transition:all .2s; width:100%; box-sizing:border-box;
}
.listen-btn:hover  { background:#fff1f2; }
.listen-btn.on     { background:var(--accent); color:white; }
.listen-btn.on:hover { background:#a01e2e; }
.stop-btn {
    display:none; align-items:center; justify-content:center; gap:6px;
    padding:8px 12px; border:1px solid var(--border);
    border-radius:6px; background:var(--surface-2); color:var(--text-2);
    cursor:pointer; font-size:13px; font-weight:500;
    transition:all .2s; width:100%; box-sizing:border-box;
}
.stop-btn.on { display:flex; }
.speech-status { font-size:12px; color:var(--text-2); text-align:center; min-height:16px; }
.speech-note   { font-size:11px; color:var(--text-2); text-align:center; line-height:1.5; opacity:.7; margin:0; }

/* ── Title input ────────────────────────────── */
.title-big {
    width:100%; padding:14px 16px;
    border:1px solid var(--border); border-radius:6px;
    font-size:22px; font-weight:700; color:var(--text-1);
    box-sizing:border-box; font-family:inherit; line-height:1.3;
    transition:border-color .2s;
}
.title-big:focus       { outline:none; border-color:var(--accent); }
.title-big::placeholder { color:#cbd5e1; }

/* ── Meta row (slug + image) ─────────────────── */
.meta-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin:10px 0 18px; }
.meta-row .form-control { font-size:13px; padding:7px 10px; color:var(--text-2); }

/* ── Category select ─────────────────────────── */
.form-control-sm {
    width:100%; padding:8px 36px 8px 10px;
    border:1px solid var(--border); border-radius:4px;
    font-size:13px; font-family:inherit; box-sizing:border-box;
    appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
    transition:border-color .2s;
}
.form-control-sm:focus { outline:none; border-color:var(--accent); }

/* ── Page header ─────────────────────────────── */
.blog-ph {
    display:flex; justify-content:space-between; align-items:center;
    flex-wrap:wrap; gap:12px;
    margin-bottom:24px; padding-bottom:18px; border-bottom:1px solid var(--border);
}
.blog-ph h1 { margin:0; font-size:24px; display:flex; align-items:center; gap:10px; }
.ph-badge {
    font-size:12px; font-weight:500; border-radius:12px;
    padding:3px 10px; vertical-align:middle;
}
.ph-badge.draft     { background:#fffbeb; color:#92400e; border:1px solid #fde68a; }
.ph-badge.published { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.ph-actions { display:flex; gap:10px; }

/* ── Section label ─────────────────────────── */
.sc-label {
    display:block; font-size:11px; font-weight:700;
    text-transform:uppercase; letter-spacing:.05em;
    color:var(--text-2); margin-bottom:5px;
}
.sc-hint { font-size:11px; color:var(--text-2); margin:0; line-height:1.5; }
</style>

<!-- ═══════════════════════════════════════════ PAGE HEADER -->
<div class="blog-ph">
    <h1>
        <?= $isEdit ? 'Edit Blog Post' : 'New Blog Post' ?>
        <?php if ($isEdit): ?>
        <span class="ph-badge <?= $statusVal ?>">
            <?= $statusVal === 'published' ? '● Published' : '✏ Draft' ?>
        </span>
        <?php endif; ?>
    </h1>
    <div class="ph-actions">
        <a href="blogs.php" class="btn btn-secondary">← Back to Posts</a>
        <?php if ($isEdit && !empty($blog['slug'])): ?>
        <a href="<?= BASE_PATH ?>/blog/post.php?slug=<?= urlencode($blog['slug']) ?>" target="_blank" class="btn btn-secondary">Preview ↗</a>
        <?php endif; ?>
    </div>
</div>

<?= $message ?>

<!-- ═══════════════════════════════════════════ FORM -->
<form method="POST" action="<?= $isEdit ? '?id='.$id : '' ?>" id="blogForm">
    <?php csrf_field(); ?>

    <!-- Hidden controlled fields -->
    <input type="hidden" name="status"    id="statusHidden"   value="<?= $statusVal ?>">
    <input type="hidden" name="read_time" id="rtHidden"       value="<?= htmlspecialchars($blog['read_time'] ?? '') ?>">
    <input type="hidden" name="keywords"  id="kwHidden"       value="<?= htmlspecialchars($blog['keywords']  ?? '') ?>">
    <input type="hidden" name="category"  id="categoryHidden" value="<?= htmlspecialchars($blog['category']  ?? '') ?>">

    <div class="blog-editor-wrap">

        <!-- ════════════ LEFT: MAIN EDITOR ════════════ -->
        <div class="blog-editor-main">
            <div class="card" style="padding:26px;">

                <!-- Title -->
                <input type="text" id="title" name="title"
                    class="title-big"
                    placeholder="Post title…"
                    value="<?= htmlspecialchars($blog['title']) ?>"
                    autocomplete="off" required>

                <!-- Slug + Feature Image -->
                <div class="meta-row">
                    <div>
                        <label class="sc-label" for="slug">URL Slug *</label>
                        <input type="text" id="slug" name="slug" class="form-control"
                            placeholder="auto-generated-from-title"
                            value="<?= htmlspecialchars($blog['slug']) ?>"
                            style="font-size:13px;padding:7px 10px;color:var(--text-2);"
                            required>
                    </div>
                    <div>
                        <label class="sc-label" for="feature_image">Feature Image URL</label>
                        <input type="text" id="feature_image" name="feature_image" class="form-control"
                            placeholder="https://… or /dashandots/assets/…"
                            value="<?= htmlspecialchars($blog['feature_image']) ?>"
                            style="font-size:13px;padding:7px 10px;">
                    </div>
                </div>

                <!-- Rich Text Editor -->
                <div class="form-group" style="margin:0;">
                    <label class="sc-label" for="content">Content *</label>
                    <textarea id="content" name="content"
                        class="form-control richtext"><?= htmlspecialchars($blog['content']) ?></textarea>
                </div>

            </div>
        </div>

        <!-- ════════════ RIGHT: SIDEBAR TOOLS ════════════ -->
        <div class="blog-editor-side">

            <!-- ── 1. PUBLISH CARD ── -->
            <div class="sc">
                <div class="sc-head">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Publish
                </div>
                <div class="sc-body">
                    <div class="status-toggle">
                        <button type="button" class="stbtn <?= $statusVal==='draft'     ? 'active':'' ?>" data-val="draft"     onclick="setStatus('draft')">✏ Draft</button>
                        <button type="button" class="stbtn <?= $statusVal==='published' ? 'active':'' ?>" data-val="published" onclick="setStatus('published')">🚀 Publish</button>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;text-align:center;">Save Post</button>
                </div>
            </div>

            <!-- ── 2. SEO & DISCOVERY CARD ── -->
            <div class="sc">
                <div class="sc-head">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    SEO & Discovery
                </div>
                <div class="sc-body">

                    <!-- Category -->
                    <div>
                        <label class="sc-label" for="catSelect">Category</label>
                        <select id="catSelect" class="form-control-sm" onchange="updateCategory()">
                            <option value="">— Uncategorised —</option>
                            <?php foreach ($categories as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= (!$isCustomCat && ($blog['category']??'')===$c) ? 'selected':'' ?>>
                                <?= htmlspecialchars($c) ?>
                            </option>
                            <?php endforeach; ?>
                            <option value="__custom__" <?= $isCustomCat ? 'selected':'' ?>>Other (custom)…</option>
                        </select>
                        <input type="text" id="catCustom" class="form-control-sm"
                            style="margin-top:7px;display:<?= $isCustomCat?'block':'none' ?>;"
                            placeholder="Type custom category…"
                            value="<?= $isCustomCat ? htmlspecialchars($blog['category']) : '' ?>"
                            oninput="document.getElementById('categoryHidden').value=this.value">
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="sc-label">
                            Keywords
                            <span style="font-weight:400;text-transform:none;font-size:10px;margin-left:4px;">(Enter or comma to add)</span>
                        </label>
                        <div class="tag-wrap" id="tagWrap" onclick="document.getElementById('tagText').focus()">
                            <span id="tagList"></span>
                            <input type="text" id="tagText" class="tag-text" placeholder="e.g. ERP software…">
                        </div>
                    </div>

                </div>
            </div>

            <!-- ── 3. READ TIME CARD ── -->
            <div class="sc">
                <div class="sc-head">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Read Time
                </div>
                <div class="sc-body">
                    <div class="rt-row">
                        <div class="rt-badge">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span id="rtDisplay"><?= !empty($blog['read_time']) ? $blog['read_time'].' min read' : 'Calculating…' ?></span>
                        </div>
                        <button type="button" class="link-btn" id="rtToggleBtn" onclick="toggleRTOverride()">Set manually</button>
                    </div>
                    <div class="rt-override" id="rtOverride">
                        <input type="number" id="rtManual" min="1" max="120" placeholder="5"
                            value="<?= htmlspecialchars($blog['read_time'] ?? '') ?>"
                            oninput="onManualRT(this.value)">
                        <span style="font-size:13px;color:var(--text-2);">minutes</span>
                        <button type="button" class="link-btn" onclick="resetRTAuto()">Auto</button>
                    </div>
                    <p class="sc-hint">Estimated ~200 wpm. Shown as "X min read" on the live post.</p>
                </div>
            </div>

            <!-- ── 4. ACCESSIBILITY CARD ── -->
            <div class="sc">
                <div class="sc-head">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                    Listen Preview
                </div>
                <div class="sc-body">
                    <button type="button" class="listen-btn" id="listenBtn" onclick="toggleSpeech()">
                        <svg id="listenIcon" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                        <span id="listenTxt">Listen to Post</span>
                    </button>
                    <button type="button" class="stop-btn" id="stopBtn" onclick="stopSpeech()">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                        Stop
                    </button>
                    <p class="speech-status" id="speechStatus"></p>
                    <p class="speech-note">Preview how this post sounds in your browser's text-to-speech engine.</p>
                </div>
            </div>

        </div><!-- /sidebar -->

    </div><!-- /grid -->
</form>

<!-- ═══════════════════════════════════════════ SCRIPTS -->
<script>
// ── Status toggle ──────────────────────────────────────
function setStatus(v) {
    document.getElementById('statusHidden').value = v;
    document.querySelectorAll('.stbtn').forEach(b => b.classList.toggle('active', b.dataset.val === v));
}

// ── Auto-slug from title ───────────────────────────────
(function(){
    const t = document.getElementById('title');
    const s = document.getElementById('slug');
    let touched = s.value.length > 0;
    s.addEventListener('input', () => { touched = true; });
    t.addEventListener('input', () => {
        if (touched) return;
        s.value = t.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g,'').trim()
            .replace(/\s+/g,'-').replace(/-+/g,'-');
    });
})();

// ── Category ───────────────────────────────────────────
(function(){
    const sel    = document.getElementById('catSelect');
    const custom = document.getElementById('catCustom');
    const hidden = document.getElementById('categoryHidden');

    window.updateCategory = function() {
        if (sel.value === '__custom__') {
            custom.style.display = 'block';
            hidden.value = custom.value.trim();
        } else {
            custom.style.display = 'none';
            hidden.value = sel.value;
        }
    };
    // Init
    hidden.value = sel.value === '__custom__' ? custom.value.trim() : sel.value;
    custom.addEventListener('input', () => { hidden.value = custom.value.trim(); });
})();

// ── Keywords tag input ─────────────────────────────────
(function(){
    const wrap   = document.getElementById('tagWrap');
    const list   = document.getElementById('tagList');
    const input  = document.getElementById('tagText');
    const hidden = document.getElementById('kwHidden');
    let tags     = [];

    const esc = s => s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

    function render() {
        list.innerHTML = '';
        tags.forEach(tag => {
            const p = document.createElement('span');
            p.className = 'tag-pill';
            p.innerHTML = `${esc(tag)}<button type="button" title="Remove">×</button>`;
            p.querySelector('button').onclick = e => { e.stopPropagation(); remove(tag); };
            list.appendChild(p);
        });
        hidden.value = tags.join(', ');
    }

    function add(t) {
        t = t.trim().replace(/^,+|,+$/g,'');
        if (!t || tags.includes(t)) return;
        tags.push(t); render();
    }

    function remove(t) { tags = tags.filter(x => x !== t); render(); }

    // Populate from saved value
    const init = hidden.value.trim();
    if (init) init.split(',').map(t=>t.trim()).filter(Boolean).forEach(add);

    input.addEventListener('keydown', function(e) {
        if (e.key==='Enter' || e.key===',') {
            e.preventDefault();
            const v = this.value.replace(/,/g,'').trim();
            if (v) { add(v); this.value = ''; }
        } else if (e.key==='Backspace' && this.value==='' && tags.length) {
            remove(tags[tags.length-1]);
        }
    });
    input.addEventListener('blur', function() {
        const v = this.value.replace(/,/g,'').trim();
        if (v) { add(v); this.value = ''; }
    });
})();

// ── Read time ──────────────────────────────────────────
let rtManual = false;

function wordCount(txt) {
    return txt.trim().split(/\s+/).filter(w=>w.length>0).length;
}
function calcRT(txt) {
    return Math.max(1, Math.ceil(wordCount(txt) / 200));
}
function setRTDisplay(mins) {
    document.getElementById('rtDisplay').textContent = mins + ' min read';
    document.getElementById('rtHidden').value = mins;
}

function toggleRTOverride() {
    const el  = document.getElementById('rtOverride');
    const btn = document.getElementById('rtToggleBtn');
    el.classList.toggle('on');
    btn.textContent = el.classList.contains('on') ? 'Hide' : 'Set manually';
}

function onManualRT(v) {
    const n = parseInt(v);
    if (n > 0) { rtManual = true; setRTDisplay(n); }
    else { rtManual = false; }
}

function resetRTAuto() {
    rtManual = false;
    document.getElementById('rtManual').value = '';
    document.getElementById('rtOverride').classList.remove('on');
    document.getElementById('rtToggleBtn').textContent = 'Set manually';
    const ed = typeof tinymce !== 'undefined' ? tinymce.get('content') : null;
    if (ed) setRTDisplay(calcRT(ed.getContent({format:'text'})));
}

// Poll for TinyMCE to initialise
(function poll(n){
    if (n > 50) return;
    const ed = typeof tinymce !== 'undefined' ? tinymce.get('content') : null;
    if (ed) {
        if (!rtManual) setRTDisplay(calcRT(ed.getContent({format:'text'})));
        ed.on('input keyup', () => { if (!rtManual) setRTDisplay(calcRT(ed.getContent({format:'text'}))); });
    } else {
        setTimeout(() => poll(n+1), 400);
    }
})(0);

// ── Text-to-Speech (Natural Voice) ─────────────────────
let _synth    = window.speechSynthesis;
let _utt      = null;
let _active   = false;
let _bestVoice = null;
let _chunks   = [];
let _chunkIdx = 0;

// ── Pick the best available natural voice ──────────────
function _loadVoices() {
    const voices = _synth.getVoices();
    if (!voices.length) return;

    // Priority list: prefer premium / natural voices
    const preferred = [
        'Google UK English Female',
        'Google US English',
        'Google UK English Male',
        'Samantha',            // macOS high-quality
        'Karen',               // macOS Australian
        'Daniel',              // macOS British
        'Microsoft Zira',      // Windows
        'Microsoft David',     // Windows
    ];

    for (const name of preferred) {
        const v = voices.find(v => v.name === name);
        if (v) { _bestVoice = v; return; }
    }

    // Fallback: first English voice that's NOT a basic "speech_" system voice
    const eng = voices.filter(v => v.lang.startsWith('en'));
    const natural = eng.find(v => !v.name.toLowerCase().includes('speech_') && !v.voiceURI.includes('speech_'));
    _bestVoice = natural || eng[0] || voices[0];
}

// Voices load async in some browsers
if (typeof speechSynthesis !== 'undefined') {
    speechSynthesis.onvoiceschanged = _loadVoices;
    _loadVoices();
}

// ── Extract clean plain text from the editor ───────────
function getArticleText() {
    const title = document.getElementById('title').value;
    const ed    = typeof tinymce !== 'undefined' ? tinymce.get('content') : null;
    let body    = ed ? ed.getContent({format:'text'}) : document.getElementById('content').value;

    // Strip any residual HTML tags
    body = body.replace(/<[^>]*>/g, ' ');
    // Decode common HTML entities
    const entityMap = {'&amp;':'&','&lt;':'<','&gt;':'>','&quot;':'"','&#39;':"'",'&nbsp;':' '};
    body = body.replace(/&(?:amp|lt|gt|quot|#39|nbsp);/g, m => entityMap[m] || m);
    // Collapse whitespace
    body = body.replace(/\s+/g, ' ').trim();

    return (title ? title + '. ' : '') + body;
}

// ── Split text into sentence-sized chunks ──────────────
// Chrome has a bug where utterances > ~200 chars stop mid-read.
// Chunking by sentence boundaries works around this.
function _splitText(text) {
    const sentences = text.match(/[^.!?]+[.!?]+[\s]*/g) || [text];
    const chunks = [];
    let buf = '';
    for (const s of sentences) {
        if ((buf + s).length > 180 && buf.length > 0) {
            chunks.push(buf.trim());
            buf = s;
        } else {
            buf += s;
        }
    }
    if (buf.trim()) chunks.push(buf.trim());
    return chunks;
}

// ── Speak next chunk in queue ──────────────────────────
function _speakNextChunk() {
    if (_chunkIdx >= _chunks.length) {
        resetSpeechUI();
        document.getElementById('speechStatus').textContent = '✓ Done.';
        setTimeout(() => { document.getElementById('speechStatus').textContent = ''; }, 3000);
        return;
    }
    _utt          = new SpeechSynthesisUtterance(_chunks[_chunkIdx]);
    _utt.rate     = 1.0;
    _utt.pitch    = 1.05;
    _utt.volume   = 1.0;
    _utt.lang     = 'en-US';
    if (_bestVoice) _utt.voice = _bestVoice;

    _utt.onend   = () => { _chunkIdx++; _speakNextChunk(); };
    _utt.onerror = (e) => {
        if (e.error === 'interrupted' || e.error === 'canceled') return; // user stop
        console.warn('TTS chunk error:', e.error);
        _chunkIdx++;
        _speakNextChunk();
    };
    _synth.speak(_utt);
}

function toggleSpeech() {
    if (!('speechSynthesis' in window)) {
        document.getElementById('speechStatus').textContent = '⚠ Not supported in this browser.';
        return;
    }
    if (_active) {
        if (_synth.paused) {
            _synth.resume();
            document.getElementById('listenTxt').textContent = 'Pause';
            document.getElementById('speechStatus').textContent = '▶ Reading…';
        } else {
            _synth.pause();
            document.getElementById('listenTxt').textContent = 'Resume';
            document.getElementById('speechStatus').textContent = '⏸ Paused';
        }
        return;
    }
    const txt = getArticleText();
    if (!txt) { document.getElementById('speechStatus').textContent = 'Nothing to read yet.'; return; }

    // Prepare chunks
    _chunks   = _splitText(txt);
    _chunkIdx = 0;
    _active   = true;
    _synth.cancel();

    document.getElementById('listenBtn').classList.add('on');
    document.getElementById('listenTxt').textContent = 'Pause';
    document.getElementById('stopBtn').classList.add('on');
    document.getElementById('speechStatus').textContent =
        '▶ Reading aloud…' + (_bestVoice ? ' (' + _bestVoice.name + ')' : '');

    _speakNextChunk();
}

function stopSpeech() {
    _synth.cancel();
    _chunks   = [];
    _chunkIdx = 0;
    resetSpeechUI();
    document.getElementById('speechStatus').textContent = '⏹ Stopped.';
    setTimeout(() => { document.getElementById('speechStatus').textContent = ''; }, 2000);
}

function resetSpeechUI() {
    _active = false;
    document.getElementById('listenBtn').classList.remove('on');
    document.getElementById('listenTxt').textContent = 'Listen to Post';
    document.getElementById('stopBtn').classList.remove('on');
}

window.addEventListener('beforeunload', () => { if ('speechSynthesis' in window) window.speechSynthesis.cancel(); });
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
