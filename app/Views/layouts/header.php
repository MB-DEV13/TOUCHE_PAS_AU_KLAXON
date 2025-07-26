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
</head>
<body class="d-flex flex-column min-vh-100">
  <header class="d-flex justify-content-center my-4">
    <div class="d-flex align-items-center justify-content-between header-box w-100" style="max-width: 1100px;">
      <!-- À gauche : le nom de l’application (dashboard si admin, sinon home) -->
<span class="fs-4 fw-bold app-title me-3">
  <?php
  if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    echo '<a href="/TOUCHE_PAS_AU_KLAXON/public/admin/dashboard" class="text-dark text-decoration-none">Touche pas au klaxon</a>';
  } elseif (!empty($_SESSION['user'])) {
    echo '<a href="/TOUCHE_PAS_AU_KLAXON/public/trajets" class="text-dark text-decoration-none">Touche pas au klaxon</a>';
  } else {
    echo '<a href="/TOUCHE_PAS_AU_KLAXON/public/" class="text-dark text-decoration-none">Touche pas au klaxon</a>';
  }
  ?>
</span>
        <!-- À droite : les boutons de connexion/déconnexion et les liens admin si admin -->

      <div class="d-flex align-items-center flex-wrap gap-2">
        <?php if (empty($_SESSION['user'])): ?>
          <?php if ($isLoginPage): ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/" class="btn btn-dark rounded-pill px-4 btn-login">Accueil</a>
          <?php else: ?>
            <a href="/TOUCHE_PAS_AU_KLAXON/public/login" class="btn btn-dark rounded-pill px-4 btn-login">Connexion</a>
          <?php endif; ?>
        <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/users" class="btn btn-secondary admin-btn">Utilisateurs</a>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/agences" class="btn btn-secondary admin-btn">Agences</a>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/trajets" class="btn btn-secondary admin-btn">Trajets</a>
          <span class="ms-3 me-2">Bonjour <b><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></b></span>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-dark rounded-pill px-4 btn-login">Déconnexion</a>
        <?php else: ?>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" class="btn btn-secondary admin-btn">Créer un trajet</a>
          <span class="ms-3 me-2">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></span>
          <a href="/TOUCHE_PAS_AU_KLAXON/public/logout" class="btn btn-dark rounded-pill px-4 btn-login">Déconnexion</a>
        <?php endif; ?>
      </div>
    </div>
  </header>







