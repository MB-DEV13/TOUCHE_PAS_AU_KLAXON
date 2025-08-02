<!-- app/Views/layouts/footer.php -->
<footer class="mt-auto text-center py-4 bg-transparent">
  <span class="fw-bold">© 2025 - TOUCHE PAS AU KLAXON</span>
  <span class="text-muted small ms-2">- MVC PHP</span>
</footer>

<script src="/TOUCHE_PAS_AU_KLAXON/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Ferme le menu quand on clique sur un lien à l'intérieur
  document.querySelectorAll('#navbarBurgerMenu a').forEach(function(link) {
    link.addEventListener('click', function() {
      var collapse = document.getElementById('navbarBurgerMenu');
      if (collapse && collapse.classList.contains('show')) {
        new bootstrap.Collapse(collapse).hide();
      }
    });
  });
});
</script>


</body>
</html>

