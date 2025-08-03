<?php require __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
    <h3 class="mb-4" style="font-family:inherit;">
        Pour obtenir plus d'informations sur un trajet, veuillez vous connecter
    </h3>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover align-middle rounded overflow-hidden">
        <thead class="table-dark">
          <tr>
            <th>Départ</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places</th>
          </tr>
        </thead>
        <tbody>
          <?php
          /**
           * Affichage des trajets disponibles (accueil non connecté).
           * Pas d'action possible ni d'infos créateur.
           *
           * @var array $trajets Liste des trajets à venir (array).
           */
          if (!empty($trajets)): ?>
            <?php foreach ($trajets as $t):
              $dateDep  = date('d/m/y', strtotime($t['date_heure_depart']));
              $heureDep = date('H:i', strtotime($t['date_heure_depart']));
              $dateArr  = date('d/m/y', strtotime($t['date_heure_arrivee']));
              $heureArr = date('H:i', strtotime($t['date_heure_arrivee']));
            ?>
            <tr>
              <td><?= htmlspecialchars($t['depart']) ?></td>
              <td><?= $dateDep ?></td>
              <td><?= $heureDep ?></td>
              <td><?= htmlspecialchars($t['arrivee']) ?></td>
              <td><?= $dateArr ?></td>
              <td><?= $heureArr ?></td>
              <td><?= (int)$t['nb_places_dispo'] ?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">Aucun trajet disponible</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>