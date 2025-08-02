<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$isLoginPage = (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/login') !== false);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/TOUCHE_PAS_AU_KLAXON/public/assets/css/style.css">
    <link rel="stylesheet" href="/TOUCHE_PAS_AU_KLAXON/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="/TOUCHE_PAS_AU_KLAXON/public/assets/images/fav.png">
    <style>
      @media (max-width: 970px) {
        .desktop-menu { display: none !important; }
        .burger-menu { display: flex !important; }
      }
      @media (min-width: 971px) {
        .desktop-menu { display: flex !important; }
        .burger-menu { display: none !important; }
      }
      .burger-menu .navbar-toggler-icon {
        display: inline-block;
        width: 2em;
        height: 2em;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center;
        /* Icône burger dark #384050 */
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(56,64,80,1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
      }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <header class="d-flex justify-content-center my-4">
    <div class="d-flex align-items-center justify-content-between header-box w-100" style="max-width: 1100px;">
      <!-- À gauche : nom de l’application -->
      <span class="fs-4 fw-bold app-title me-3">
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/dashboard" class="text-dark text-decoration-none">Touche pas au klaxon</a>
        <?php elseif (!empty($_SESSION['user'])): ?>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/trajets" class="text-dark text-decoration-none">Touche pas au klaxon</a>
        <?php else: ?>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/" class="text-dark text-decoration-none">Touche pas au klaxon</a>
        <?php endif; ?>
      </span>

      <!-- Menu normal (desktop) -->
      <div class="d-flex align-items-center flex-wrap gap-2 desktop-menu">
        <?php if (empty($_SESSION['user'])): ?>
          <?php if ($isLoginPage): ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/" class="btn btn-dark rounded-pill px-4 btn-login">Accueil</a>
          <?php else: ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/login" class="btn btn-dark rounded-pill px-4 btn-login">Connexion</a>
          <?php endif; ?>
        <?php else: ?>
          <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/dashboard" class="btn btn-secondary admin-btn">Accueil</a>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" class="btn btn-secondary admin-btn">Créer un trajet</a>
            <span class="ms-3 me-2">Bonjour <b><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></b></span>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-danger rounded-pill px-4 btn-login">Déconnexion</a>
          <?php else: ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/trajets" class="btn btn-secondary admin-btn">Accueil</a>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" class="btn btn-secondary admin-btn">Créer un trajet</a>
            <span class="ms-3 me-2">Bonjour <b><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></b></span>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-danger rounded-pill px-4 btn-login">Déconnexion</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Menu burger (mobile) -->
      <div class="burger-menu" style="display:none; position: relative;">
        <button class="navbar-toggler ms-2" type="button" id="burgerToggler" aria-controls="navbarBurgerMenu" aria-expanded="false" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse position-absolute end-0 mt-5" id="navbarBurgerMenu" style="min-width: 220px; z-index:999; background:transparent;">
          <div class="bg-white rounded shadow p-3">
            <?php if (empty($_SESSION['user'])): ?>
              <?php if ($isLoginPage): ?>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/" class="btn btn-dark w-100 mb-2">Accueil</a>
              <?php else: ?>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/login" class="btn btn-dark w-100 mb-2">Connexion</a>
              <?php endif; ?>
            <?php else: ?>
              <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/dashboard" class="btn btn-secondary w-100 mb-2">Accueil</a>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" class="btn btn-secondary w-100 mb-2">Créer un trajet</a>
                <div class="text-center small text-dark mb-2">Bonjour <b><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></b></div>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-danger w-100">Déconnexion</a>
              <?php else: ?>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/trajets" class="btn btn-secondary w-100 mb-2">Accueil</a>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" class="btn btn-secondary w-100 mb-2">Créer un trajet</a>
                <div class="text-center small text-dark mb-2">Bonjour <b><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></b></div>
                <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-danger w-100">Déconnexion</a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </header>

<!-- ... suite de ta page ... -->

<!-- Ajoute Bootstrap JS si tu l’utilises, sinon juste ce JS -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const burgerBtn = document.getElementById('burgerToggler');
    const burgerMenu = document.getElementById('navbarBurgerMenu');
    let menuOpen = false;
    burgerBtn.addEventListener('click', function(e) {
      menuOpen = !menuOpen;
      burgerMenu.classList.toggle('show', menuOpen);
      burgerBtn.setAttribute('aria-expanded', menuOpen ? 'true' : 'false');
    });
    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function(e) {
      if (
        menuOpen &&
        !burgerMenu.contains(e.target) &&
        !burgerBtn.contains(e.target)
      ) {
        burgerMenu.classList.remove('show');
        burgerBtn.setAttribute('aria-expanded', 'false');
        menuOpen = false;
      }
    });
    // (Optionnel) Fermer le menu sur lien cliqué
    burgerMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        burgerMenu.classList.remove('show');
        burgerBtn.setAttribute('aria-expanded', 'false');
        menuOpen = false;
      });
    });
  });
</script>










