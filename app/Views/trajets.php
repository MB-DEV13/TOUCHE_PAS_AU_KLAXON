<?php require __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">

  <?php
  // Affiche le message flash s'il existe (à placer juste sous le header)
  if (function_exists('get_flash_message')) {
    if ($msg = get_flash_message()) {
      echo '<div class="alert alert-success" style="border-radius: 10px;">' . htmlspecialchars($msg) . '</div>';
    }
  }
  ?>

  <?php if (empty($trajets)): ?>
    <h2 class="mb-4">Aucun trajet actuellement</h2>
  <?php else: ?>
    <h2 class="mb-4">Trajets proposés</h2>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle rounded overflow-hidden" style="border-radius: 12px; overflow: hidden;">
      <thead class="table-dark">
        <tr>
          <th>Départ</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Destination</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Places</th>
          <th><!-- Action --></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($trajets)): ?>
          <tr>
            <td colspan="8" class="text-center">Aucun trajet disponible</td>
          </tr>
        <?php else: ?>
          <?php foreach ($trajets as $trajet): ?>
            <tr>
              <td><?= htmlspecialchars($trajet['depart']) ?></td>
              <td><?= date('d/m/Y', strtotime($trajet['date_depart'])) ?></td>
              <td><?= date('H:i', strtotime($trajet['date_depart'])) ?></td>
              <td><?= htmlspecialchars($trajet['arrivee']) ?></td>
              <td><?= date('d/m/Y', strtotime($trajet['date_arrivee'])) ?></td>
              <td><?= date('H:i', strtotime($trajet['date_arrivee'])) ?></td>
              <td><?= (int)$trajet['places_disponibles'] ?></td>
              <td class="text-center">
                <!-- Voir les infos (modale) -->
                <button
                  class="btn btn-link p-0 me-2"
                  data-bs-toggle="modal"
                  data-bs-target="#modalInfos<?= $trajet['id_trajet'] ?>"
                  title="Voir infos">
                  <span class="bi bi-eye"></span>
                </button>
                <?php if ($_SESSION['user']['id'] == $trajet['id_createur']): ?>
                  <!-- Modifier -->
                  <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/edit/<?= $trajet['id_trajet'] ?>" class="btn btn-link p-0 me-2" title="Modifier">
                    <span class="bi bi-pencil"></span>
                  </a>
                  <!-- Supprimer (direct, sans confirm JS) -->
                  <a href="/TOUCHE_PAS_AU_KLAXON/public/trajet/delete/<?= $trajet['id_trajet'] ?>" class="btn btn-link p-0" title="Supprimer">
                    <span class="bi bi-trash"></span>
                  </a>
                <?php endif; ?>
              </td>
            </tr>

            <!-- Modal infos complémentaires -->
            <div class="modal fade" id="modalInfos<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-labelledby="infosModalLabel<?= $trajet['id_trajet'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="infosModalLabel<?= $trajet['id_trajet'] ?>">Infos du trajet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                  </div>
                  <div class="modal-body">
                    <ul class="list-unstyled mb-0">
                      <li><strong>Proposé par :</strong> <?= htmlspecialchars($trajet['prenom_createur']) ?> <?= htmlspecialchars($trajet['nom_createur']) ?></li>
                      <li><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['telephone_createur']) ?></li>
                      <li><strong>Email :</strong> <?= htmlspecialchars($trajet['email_createur']) ?></li>
                      <li><strong>Nombre total de places :</strong> <?= (int)$trajet['places_total'] ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>


