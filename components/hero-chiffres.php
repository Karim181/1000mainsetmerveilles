<!-- Compteur chiffres clés -->
<?php
$chiffres = [
    ['key' => 'compteur1', 'default_nb' => '12', 'default_label' => "ans d'engagement", 'suffix' => ''],
    ['key' => 'compteur2', 'default_nb' => '200', 'default_label' => 'benevoles', 'suffix' => '+'],
    ['key' => 'compteur3', 'default_nb' => '2', 'default_label' => 'lieux en Yvelines', 'suffix' => ''],
    ['key' => 'compteur4', 'default_nb' => '1000', 'default_label' => 'mains pour agir', 'suffix' => ''],
];
?>
<div class="hero-chiffres">
    <?php foreach ($chiffres as $c): ?>
    <?php
        $nb = page_content('global', $c['key'] . '-nb', $c['default_nb']);
        $label = page_content('global', $c['key'] . '-label', $c['default_label']);
        $suffix = page_content('global', $c['key'] . '-suffix', $c['suffix']);
    ?>
    <div class="hero-chiffre">
        <span class="hero-chiffre-nb" data-count="<?= e($nb) ?>"<?php if ($suffix): ?> data-suffix="<?= e($suffix) ?>"<?php endif; ?>>0</span>
        <span class="hero-chiffre-label"><?= e($label) ?></span>
    </div>
    <?php endforeach; ?>
</div>
<script>
(function() {
    if (window._heroChiffresInit) return;
    window._heroChiffresInit = true;

    document.addEventListener('DOMContentLoaded', function() {
        var counters = document.querySelectorAll('[data-count]');
        var animated = false;

        function animateCounters() {
            if (animated) return;
            animated = true;

            counters.forEach(function(el) {
                var target = parseInt(el.getAttribute('data-count'));
                var suffix = el.getAttribute('data-suffix') || '';
                var duration = 2000;
                var startTime = null;

                function easeOutQuart(t) {
                    return 1 - Math.pow(1 - t, 4);
                }

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    var current = Math.floor(easeOutQuart(progress) * target);
                    el.textContent = current + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        el.textContent = target + suffix;
                    }
                }

                requestAnimationFrame(step);
            });
        }

        var chiffres = document.querySelector('.hero-chiffres');
        if (chiffres) {
            var observer = new IntersectionObserver(function(entries) {
                if (entries[0].isIntersecting) {
                    animateCounters();
                    observer.disconnect();
                }
            }, { threshold: 0.5 });
            observer.observe(chiffres);
        }
    });
})();
</script>
