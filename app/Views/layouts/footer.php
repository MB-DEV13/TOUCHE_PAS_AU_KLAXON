<?php
/**
 * Pied de page global de l’application.
 * Affiche le copyright, l’identité et charge les scripts JS principaux.
 */
?>

<footer class="mt-auto text-center py-4 bg-transparent">
  <span class="fw-bold">© 2025 - TOUCHE PAS AU KLAXON</span>
  <span class="text-muted small ms-2">- MVC PHP</span>
</footer>

<!-- Bootstrap JS (nécessaire pour le menu burger et les modales Bootstrap) -->
<script src="/TOUCHE_PAS_AU_KLAXON/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
/**
 * JS pour fermer le menu burger mobile automatiquement lorsqu'on clique sur un lien du menu.
 */
document.addEventListener("DOMContentLoaded", function() {
  var burgerMenu = document.getElementById('navbarBurgerMenu');
  if (burgerMenu) {
    burgerMenu.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function() {
        burgerMenu.classList.remove('show');
        // Met à jour aria-expanded du bouton si besoin
        var burgerBtn = document.getElementById('burgerToggler');
        if (burgerBtn) burgerBtn.setAttribute('aria-expanded', 'false');
      });
    });
  }
});
</script>

</body>
</html>

