<?php require __DIR__ . '/layouts/header.php'; ?>

<div class="container my-5">
  <div class="card shadow-sm border-0 login-box mx-auto">
    <div class="card-body">
      <h2 class="card-title mb-4 text-center">Connexion</h2>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form action="/TOUCHE_PAS_AU_KLAXON/public/login" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Adresse email</label>
          <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-dark w-100">Se connecter</button>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>

