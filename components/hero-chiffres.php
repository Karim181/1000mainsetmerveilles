<!-- Compteur chiffres clés -->
<div class="hero-chiffres">
    <div class="hero-chiffre">
        <span class="hero-chiffre-nb" data-count="12">0</span>
        <span class="hero-chiffre-label">ans d'engagement</span>
    </div>
    <div class="hero-chiffre">
        <span class="hero-chiffre-nb" data-count="200" data-suffix="+">0</span>
        <span class="hero-chiffre-label">benevoles</span>
    </div>
    <div class="hero-chiffre">
        <span class="hero-chiffre-nb" data-count="2">0</span>
        <span class="hero-chiffre-label">lieux en Yvelines</span>
    </div>
    <div class="hero-chiffre">
        <span class="hero-chiffre-nb" data-count="1000">0</span>
        <span class="hero-chiffre-label">mains pour agir</span>
    </div>
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
