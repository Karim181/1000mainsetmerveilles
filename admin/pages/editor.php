<?php
/**
 * Editeur visuel inline - Admin
 * 1000 Mains et Merveilles
 *
 * Charge la vraie page dans un iframe et permet de modifier
 * les textes en cliquant dessus (contenteditable).
 * La disposition reste fixe, seul le wording est modifiable.
 */

auth_require();

$slug = $_GET['slug'] ?? '';

$pages = [
    'home' => 'Accueil',
    'qui-sommes-nous' => 'Qui sommes-nous',
    'la-ressourcerie' => 'La Ressourcerie',
    'dons' => 'Faire un don',
    'venir-chiner' => 'Venir chiner',
    'nous-rejoindre' => 'Nous rejoindre',
];

if (!isset($pages[$slug])) {
    header('Location: ' . admin_url('pages') . '?error=' . urlencode('Page introuvable.'));
    exit;
}

// Charger les contenus editables de cette page
$contents = dbFetchAll(
    'SELECT id, section_key, content_type, content_text, content_image, label FROM page_contents WHERE page_slug = ? ORDER BY id',
    [$slug]
);

$csrfToken = csrf_token();
$pageUrl = url($slug === 'home' ? '' : $slug);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editeur - <?= e($pages[$slug]) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; overflow: hidden; background: #1e1e1e; }

        .editor-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 50px;
            padding: 0 20px;
            background: #2d2d2d;
            color: white;
            border-bottom: 1px solid #444;
            z-index: 100;
        }

        .editor-topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .editor-topbar-left a {
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }

        .editor-topbar-left a:hover { color: white; }

        .editor-topbar-title {
            font-size: 14px;
            font-weight: 600;
        }

        .editor-topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .editor-save-btn {
            padding: 7px 22px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.2s;
        }

        .editor-save-btn:hover { background: #45a049; }
        .editor-save-btn:disabled { background: #555; cursor: not-allowed; }

        .editor-status {
            font-size: 12px;
            color: #aaa;
            min-width: 120px;
            text-align: right;
        }

        .editor-changes {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 12px;
            background: #444;
            color: #ccc;
        }

        .editor-changes.has-changes {
            background: #f59e0b;
            color: #000;
        }

        .editor-body {
            display: flex;
            height: calc(100vh - 50px);
        }

        /* Sidebar avec les champs */
        .editor-sidebar {
            width: 340px;
            background: #2d2d2d;
            border-right: 1px solid #444;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .sidebar-section {
            padding: 15px;
            border-bottom: 1px solid #3a3a3a;
        }

        .sidebar-section h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 12px;
        }

        .field-item {
            margin-bottom: 14px;
        }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #bbb;
            margin-bottom: 5px;
        }

        .field-key {
            font-size: 10px;
            color: #666;
            font-family: monospace;
        }

        .field-input {
            width: 100%;
            padding: 8px 10px;
            background: #1e1e1e;
            border: 1px solid #444;
            border-radius: 6px;
            color: #eee;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            resize: vertical;
            transition: border-color 0.2s;
        }

        .field-input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .field-input.modified {
            border-color: #f59e0b;
            background: #2a2518;
        }

        textarea.field-input {
            min-height: 60px;
        }

        .field-type-badge {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            background: #3a3a3a;
            color: #999;
        }

        .field-type-badge.image { background: #1e3a2a; color: #4CAF50; }

        /* Preview iframe */
        .editor-preview {
            flex: 1;
            background: white;
        }

        .editor-preview iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Highlight dans l'iframe */
        .editor-highlight-btn {
            padding: 4px 10px;
            background: #3a3a3a;
            color: #ccc;
            border: 1px solid #555;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
        }

        .editor-highlight-btn:hover { background: #4a4a4a; }
        .editor-highlight-btn.active { background: #4CAF50; color: white; border-color: #4CAF50; }
    </style>
</head>
<body>

<div class="editor-topbar">
    <div class="editor-topbar-left">
        <a href="<?= admin_url('pages') ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
        <span class="editor-topbar-title"><?= e($pages[$slug]) ?></span>
    </div>
    <div class="editor-topbar-right">
        <span class="editor-changes" id="changesCount">0 modification</span>
        <span class="editor-status" id="saveStatus"></span>
        <button class="editor-save-btn" id="saveBtn" onclick="saveAll()" disabled>Sauvegarder</button>
    </div>
</div>

<div class="editor-body">
    <div class="editor-sidebar">
        <?php
        // Grouper par type de section
        $groups = [];
        foreach ($contents as $c) {
            $parts = explode('-', $c['section_key'], 2);
            $group = $parts[0] ?? 'autre';
            $groups[$group][] = $c;
        }

        foreach ($groups as $groupName => $fields):
            $groupLabels = [
                'hero' => 'Hero / En-tete',
                'page' => 'Page (SEO)',
                'nav' => 'Navigation',
                'tag' => 'Pastilles',
                'actions' => 'Sections',
                'mission' => 'Mission',
                'pepites' => 'Pepites',
                'categories' => 'Categories',
                'pedagogie' => 'Contenu',
            ];
            $groupLabel = $groupLabels[$groupName] ?? ucfirst($groupName);
        ?>
        <div class="sidebar-section">
            <h3><?= e($groupLabel) ?></h3>
            <?php foreach ($fields as $field): ?>
            <div class="field-item">
                <div class="field-label">
                    <span><?= e($field['label']) ?></span>
                    <span class="field-type-badge <?= $field['content_type'] === 'image' ? 'image' : '' ?>"><?= $field['content_type'] ?></span>
                </div>
                <?php if ($field['content_type'] === 'image'): ?>
                    <div style="display: flex; gap: 6px; align-items: center;">
                        <?php if ($field['content_image'] ?? $field['content_text']): ?>
                            <img src="<?= upload_url('pages/' . ($field['content_image'] ?? $field['content_text'])) ?>" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;">
                        <?php endif; ?>
                        <span class="field-key"><?= e($field['section_key']) ?></span>
                    </div>
                <?php elseif ($field['content_type'] === 'textarea'): ?>
                    <textarea
                        class="field-input"
                        data-id="<?= $field['id'] ?>"
                        data-key="<?= e($field['section_key']) ?>"
                        data-original="<?= e($field['content_text'] ?? '') ?>"
                        oninput="onFieldChange(this)"
                    ><?= e($field['content_text'] ?? '') ?></textarea>
                <?php else: ?>
                    <input
                        type="text"
                        class="field-input"
                        data-id="<?= $field['id'] ?>"
                        data-key="<?= e($field['section_key']) ?>"
                        data-original="<?= e($field['content_text'] ?? '') ?>"
                        value="<?= e($field['content_text'] ?? '') ?>"
                        oninput="onFieldChange(this)"
                    >
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="editor-preview">
        <iframe id="previewFrame" src="<?= e($pageUrl) ?>"></iframe>
    </div>
</div>

<script>
const CSRF_TOKEN = <?= json_encode($csrfToken) ?>;
const SAVE_URL = <?= json_encode(admin_url('pages/editor-save')) ?>;
const PAGE_SLUG = <?= json_encode($slug) ?>;

let changedFields = new Map();

function onFieldChange(el) {
    const id = el.dataset.id;
    const original = el.dataset.original;
    const current = el.value;

    if (current !== original) {
        el.classList.add('modified');
        changedFields.set(id, {
            id: id,
            key: el.dataset.key,
            value: current,
        });
    } else {
        el.classList.remove('modified');
        changedFields.delete(id);
    }

    updateUI();
}

function updateUI() {
    const count = changedFields.size;
    const badge = document.getElementById('changesCount');
    const btn = document.getElementById('saveBtn');

    badge.textContent = count + ' modification' + (count > 1 ? 's' : '');
    badge.classList.toggle('has-changes', count > 0);
    btn.disabled = count === 0;
}

function saveAll() {
    if (changedFields.size === 0) return;

    const btn = document.getElementById('saveBtn');
    const status = document.getElementById('saveStatus');

    btn.disabled = true;
    btn.textContent = 'Sauvegarde...';
    status.textContent = '';

    const fields = Array.from(changedFields.values());

    fetch(SAVE_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            csrf_token: CSRF_TOKEN,
            page_slug: PAGE_SLUG,
            fields: fields,
        }),
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            status.textContent = 'Sauvegarde OK';
            status.style.color = '#4CAF50';

            // Mettre a jour les originaux
            document.querySelectorAll('.field-input.modified').forEach(el => {
                el.dataset.original = el.value;
                el.classList.remove('modified');
            });
            changedFields.clear();
            updateUI();

            // Rafraichir l'apercu
            document.getElementById('previewFrame').contentWindow.location.reload();
        } else {
            status.textContent = 'Erreur : ' + (res.error || 'inconnue');
            status.style.color = '#f44336';
        }
    })
    .catch(err => {
        status.textContent = 'Erreur reseau';
        status.style.color = '#f44336';
    })
    .finally(() => {
        btn.disabled = changedFields.size === 0;
        btn.textContent = 'Sauvegarder';
        setTimeout(() => { status.textContent = ''; }, 4000);
    });
}

// Raccourci Ctrl+S
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveAll();
    }
});
</script>
</body>
</html>
