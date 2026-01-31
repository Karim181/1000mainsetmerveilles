<!-- ========== NAVBAR ========== -->
<nav class="navbar-final">
    <div class="container">
        <div class="navbar-content">
            <a href="<?= url() ?>" class="navbar-logo-final">
                <div class="logo-final-circle">
                    <img src="<?= asset('images/1000-mains-et-merveilles-1-2.png') ?>" alt="1000 Mains et Merveilles">
                </div>
                <span class="logo-text-final">
                    <strong>1000 Mains</strong>
                    <small>et Merveilles</small>
                </span>
            </a>

            <!-- Menu burger mobile -->
            <button class="navbar-burger" aria-label="Menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="navbar-menu-final">
                <li><a href="<?= url() ?>" class="<?= is_page('home') ? 'nav-active' : '' ?>">Qui sommes-nous ?</a></li>
                <li><a href="<?= url('la-ressourcerie') ?>" class="<?= is_page('la-ressourcerie') ? 'nav-active' : '' ?>">La Ressourcerie</a></li>
                <li><a href="<?= url('venir-chiner') ?>" class="<?= is_page('venir-chiner') ? 'nav-active' : '' ?>">Venir chiner</a></li>
                <li><a href="<?= url('dons') ?>" class="nav-highlight <?= is_page('dons') ? 'nav-active' : '' ?>">Faire un don</a></li>
                <li><a href="<?= url('agenda') ?>" class="<?= is_page('agenda') ? 'nav-active' : '' ?>">Agenda</a></li>
                <li><a href="<?= url('nous-rejoindre') ?>" class="btn-nav-final <?= is_page('nous-rejoindre') ? 'nav-active' : '' ?>">Nous rejoindre</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="navbar-overlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var burger = document.querySelector('.navbar-burger');
    var menu = document.querySelector('.navbar-menu-final');
    var overlay = document.querySelector('.navbar-overlay');

    function toggleMenu() {
        burger.classList.toggle('is-active');
        menu.classList.toggle('is-active');
        overlay.classList.toggle('is-active');
        var expanded = burger.getAttribute('aria-expanded') === 'true';
        burger.setAttribute('aria-expanded', !expanded);
    }

    function closeMenu() {
        burger.classList.remove('is-active');
        menu.classList.remove('is-active');
        overlay.classList.remove('is-active');
        burger.setAttribute('aria-expanded', 'false');
    }

    burger.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', closeMenu);

    var links = menu.querySelectorAll('a');
    for (var i = 0; i < links.length; i++) {
        links[i].addEventListener('click', closeMenu);
    }
});
</script>
