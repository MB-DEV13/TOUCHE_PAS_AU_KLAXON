<?php require __DIR__ . '/layouts/header.php'; ?>

<div class="container my-5" style="max-width:600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4 text-center">Créer un trajet</h2>

            <?php
            /**
             * Affiche une alerte si une erreur de validation a été passée par le contrôleur.
             */
            if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!--
            Formulaire de création de trajet.
            Méthode POST sécurisée.
            -->
            <form action="/TOUCHE_PAS_AU_KLAXON/public/trajet/creer" method="post" autocomplete="off">

                <!-- Sélection du lieu de départ -->
                <div class="mb-3">
                    <label class="form-label">Départ</label>
                    <select name="depart" class="form-select" required>
                        <option value="">-- Choisir une agence --</option>
                        <?php foreach ($agences as $ag): ?>
                            <option value="<?= $ag['id_agence'] ?>" <?= (!empty($old['depart']) && $old['depart'] == $ag['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ag['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sélection du lieu d'arrivée -->
                <div class="mb-3">
                    <label class="form-label">Arrivée</label>
                    <select name="arrivee" class="form-select" required>
                        <option value="">-- Choisir une agence --</option>
                        <?php foreach ($agences as $ag): ?>
                            <option value="<?= $ag['id_agence'] ?>" <?= (!empty($old['arrivee']) && $old['arrivee'] == $ag['id_agence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ag['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dates et heures de départ et d'arrivée -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date départ</label>
                        <input type="date" name="date_depart" class="form-control" required value="<?= htmlspecialchars($old['date_depart'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Heure départ</label>
                        <input type="time" name="heure_depart" class="form-control" required value="<?= htmlspecialchars($old['heure_depart'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date arrivée</label>
                        <input type="date" name="date_arrivee" class="form-control" required value="<?= htmlspecialchars($old['date_arrivee'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Heure arrivée</label>
                        <input type="time" name="heure_arrivee" class="form-control" required value="<?= htmlspecialchars($old['heure_arrivee'] ?? '') ?>">
                    </div>
                </div>

                <!-- Nombre de places (contrôle min/max inclus) -->
                <div class="mb-3">
                    <label class="form-label">Nombre de places</label>
                    <input type="number" name="places" class="form-control" min="1" max="50" required value="<?= htmlspecialchars($old['places'] ?? '') ?>">
                </div>

                <!-- Nom et prénom de l'utilisateur proposant le trajet, non modifiables -->
                <div class="mb-3">
                    <label class="form-label">Proposé par</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>" disabled>
                </div>

                <button type="submit" class="btn btn-dark w-100">Créer le trajet</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>
