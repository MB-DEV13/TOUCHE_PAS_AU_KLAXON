<?php require __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Dashboard Administrateur</h2>

    <!-- Message flash de succès ou d'erreur -->
    <?php if (function_exists('get_flash_message')): ?>
      <?php if ($msg = get_flash_message()): ?>
        <div class="alert alert-<?= strpos($msg, 'Erreur') === false ? 'success' : 'danger' ?>" style="border-radius: 10px;">
          <?= htmlspecialchars($msg) ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Tableau des trajets à venir -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white fs-5">
            Trajets
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle rounded overflow-hidden mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Départ</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Destination</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Places</th>
                            <th>Créateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($trajets)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Aucun trajet</td>
                            </tr>
                        <?php else: foreach ($trajets as $trajet): ?>
                            <tr>
                                <td><?= htmlspecialchars($trajet['depart']) ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['date_depart'])) ?></td>
                                <td><?= date('H:i', strtotime($trajet['date_depart'])) ?></td>
                                <td><?= htmlspecialchars($trajet['arrivee']) ?></td>
                                <td><?= date('d/m/Y', strtotime($trajet['date_arrivee'])) ?></td>
                                <td><?= date('H:i', strtotime($trajet['date_arrivee'])) ?></td>
                                <td><?= (int)$trajet['places_disponibles']?></td>
                                <td><?= htmlspecialchars($trajet['prenom_createur']) . ' ' . htmlspecialchars($trajet['nom_createur']) ?></td>
                                <td>
                                    <!-- Voir infos trajet (modale) -->
                                    <button class="btn btn-link p-0 me-2" data-bs-toggle="modal"
                                            data-bs-target="#modalInfos<?= $trajet['id_trajet'] ?>" title="Voir infos">
                                        <span class="bi bi-eye"></span>
                                    </button>
                                    <!-- Modifier trajet (modale) -->
                                    <button class="btn btn-link p-0 me-2" data-bs-toggle="modal"
                                            data-bs-target="#modalEditTrajet<?= $trajet['id_trajet'] ?>" title="Modifier">
                                        <span class="bi bi-pencil"></span>
                                    </button>
                                    <!-- Supprimer trajet -->
                                    <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/trajet/delete/<?= $trajet['id_trajet'] ?>"
                                       class="btn btn-link p-0 text-danger" title="Supprimer"
                                       onclick="return confirm('Supprimer ce trajet ?');">
                                        <span class="bi bi-trash"></span>
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal infos trajet -->
                            <div class="modal fade" id="modalInfos<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-labelledby="infosModalLabel<?= $trajet['id_trajet'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="infosModalLabel<?= $trajet['id_trajet'] ?>">Infos du trajet</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

                            <!-- Modal édition trajet -->
                            <div class="modal fade" id="modalEditTrajet<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $trajet['id_trajet'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="post" action="/TOUCHE_PAS_AU_KLAXON/public/admin/trajet/edit/<?= $trajet['id_trajet'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?= $trajet['id_trajet'] ?>">Modifier le trajet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Départ</label>
                                                    <select name="depart" class="form-select" required>
                                                        <?php foreach ($agences as $ag): ?>
                                                            <option value="<?= $ag['id_agence'] ?>" <?= $ag['id_agence'] == $trajet['id_agence_depart'] ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($ag['nom']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Date départ</label>
                                                    <input type="date" name="date_depart" class="form-control"
                                                           value="<?= date('Y-m-d', strtotime($trajet['date_depart'])) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Heure départ</label>
                                                    <input type="time" name="heure_depart" class="form-control"
                                                           value="<?= date('H:i', strtotime($trajet['date_depart'])) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Destination</label>
                                                    <select name="arrivee" class="form-select" required>
                                                        <?php foreach ($agences as $ag): ?>
                                                            <option value="<?= $ag['id_agence'] ?>" <?= $ag['id_agence'] == $trajet['id_agence_arrivee'] ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($ag['nom']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Date arrivée</label>
                                                    <input type="date" name="date_arrivee" class="form-control"
                                                           value="<?= date('Y-m-d', strtotime($trajet['date_arrivee'])) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Heure arrivée</label>
                                                    <input type="time" name="heure_arrivee" class="form-control"
                                                           value="<?= date('H:i', strtotime($trajet['date_arrivee'])) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Places</label>
                                                    <input type="number" name="places" class="form-control"
                                                           value="<?= (int)$trajet['places_total'] ?>" min="1" max="50" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Deux colonnes : Utilisateurs et Agences -->
    <div class="row g-4">
        <!-- Utilisateurs -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white fs-5">
                    Utilisateurs
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle rounded overflow-hidden mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Aucun utilisateur</td>
                                    </tr>
                                <?php else: foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['prenom']) ?> <?= htmlspecialchars($user['nom']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Agences -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center fs-5">
                    <span>Agences</span>
                    <!-- BTN MODAL AJOUT -->
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddAgence">
                        <i class="bi bi-plus"></i> Ajouter
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle rounded overflow-hidden mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($agences)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center">Aucune agence</td>
                                    </tr>
                                <?php else: foreach ($agences as $agence): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($agence['nom']) ?></td>
                                        <td>
                                            <!-- BTN MODIFIER = modale -->
                                            <button type="button" class="btn btn-link text-primary p-0 me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditAgence<?= $agence['id_agence'] ?>"
                                                    title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <!-- BTN SUPPRIMER -->
                                            <a href="/TOUCHE_PAS_AU_KLAXON/public/admin/agence/delete/<?= $agence['id_agence'] ?>" class="text-danger" title="Supprimer" onclick="return confirm('Supprimer cette agence ?');"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>

                                    <!-- MODALE EDITION AGENCE -->
                                    <div class="modal fade" id="modalEditAgence<?= $agence['id_agence'] ?>" tabindex="-1" aria-labelledby="editAgenceLabel<?= $agence['id_agence'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="post" action="/TOUCHE_PAS_AU_KLAXON/public/admin/agence/edit/<?= $agence['id_agence'] ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editAgenceLabel<?= $agence['id_agence'] ?>">Modifier l'agence</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($agence['nom']) ?>" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALE AJOUT AGENCE -->
<div class="modal fade" id="modalAddAgence" tabindex="-1" aria-labelledby="addAgenceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="/TOUCHE_PAS_AU_KLAXON/public/admin/agence/create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAgenceLabel">Ajouter une agence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nom" class="form-control" placeholder="Nom de l'agence" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Créer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>



