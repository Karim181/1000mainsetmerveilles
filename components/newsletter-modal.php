<!-- ========== MODAL NEWSLETTER ========== -->
<div class="newsletter-modal-overlay" id="newsletterModal">
    <div class="newsletter-modal">
        <button class="newsletter-modal-close" id="newsletterClose" aria-label="Fermer">&times;</button>
        <div class="newsletter-modal-header">
            <span class="newsletter-modal-icon">📬</span>
            <h3>Inscrivez-vous a notre newsletter</h3>
            <p>Recevez nos actualites, evenements et bons plans directement dans votre boite mail.</p>
        </div>
        <form class="newsletter-modal-form" id="newsletterForm">
            <div class="newsletter-form-row">
                <div class="newsletter-form-group">
                    <label for="nl-prenom">Prenom *</label>
                    <input type="text" id="nl-prenom" name="prenom" required placeholder="Votre prenom">
                </div>
                <div class="newsletter-form-group">
                    <label for="nl-nom">Nom *</label>
                    <input type="text" id="nl-nom" name="nom" required placeholder="Votre nom">
                </div>
            </div>
            <div class="newsletter-form-group">
                <label for="nl-email">Adresse email *</label>
                <input type="email" id="nl-email" name="email" required placeholder="votre@email.com">
            </div>
            <div class="newsletter-form-check">
                <input type="checkbox" id="nl-consent" name="consent" required>
                <label for="nl-consent">J'accepte de recevoir des informations par email de la part de 1000 Mains et Merveilles. Je peux me desinscrire a tout moment.</label>
            </div>
            <button type="submit" class="newsletter-modal-submit">Valider mon inscription</button>
        </form>
        <div class="newsletter-modal-success" id="newsletterSuccess" style="display: none;">
            <span class="newsletter-success-icon">✅</span>
            <h3>Merci pour votre inscription !</h3>
            <p>Vous recevrez bientot de nos nouvelles.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('newsletterModal');
    var closeBtn = document.getElementById('newsletterClose');
    var form = document.getElementById('newsletterForm');
    var success = document.getElementById('newsletterSuccess');

    // Ouvrir la modal
    document.querySelectorAll('[data-newsletter]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Fermer la modal
    function closeModal() {
        modal.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // Soumission du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Envoi...';

        var data = {
            first_name: document.getElementById('nl-prenom').value.trim(),
            last_name: document.getElementById('nl-nom').value.trim(),
            email: document.getElementById('nl-email').value.trim()
        };

        fetch('<?= rtrim(BASE_URL, "/") ?>/api/newsletter.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                form.style.display = 'none';
                success.style.display = 'block';
                setTimeout(closeModal, 3000);
            } else {
                var msg = res.errors ? res.errors.join(' ') : (res.error || 'Erreur inconnue');
                alert(msg);
            }
        })
        .catch(function() {
            alert('Erreur reseau, veuillez reessayer.');
        })
        .finally(function() {
            btn.disabled = false;
            btn.textContent = 'Valider mon inscription';
        });
    });
});
</script>
