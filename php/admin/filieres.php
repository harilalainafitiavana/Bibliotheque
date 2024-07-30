<?php
require_once '../config.php';

$sql = 'SELECT * FROM filieres';
$stmt = $conn->query($sql);
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'admin_top.php';
?>

<div>
    <h1 class="text-center mt-4 mb-3 fs-1" style="color: #21D192;">Liste des filières</h1>
    <table class="table table-striped">
        <thead>
            <tr class="highlight">
                <th style="  background-color: #21D192; color:white;">ID</th>
                <th style="  background-color: #21D192; color:white;">Nom</th>
                <th style="  background-color: #21D192; color:white;">Description</th>
                <th style="  background-color: #21D192; color:white;">Année d'étude</th>
                <th style="  background-color: #21D192; color:white;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filieres as $filiere) : ?>
                <tr>
                    <td><?= htmlspecialchars($filiere['id']) ?></td>
                    <td><?= htmlspecialchars($filiere['name']) ?></td>
                    <td><?= htmlspecialchars($filiere['description']) ?></td>
                    <td><?= htmlspecialchars($filiere['study_year']) ?></td>
                    <td class="d-flex">
                        <a href="modifier_filiere?id=<?= htmlspecialchars($filiere['id']) ?>" class=""><i class="bi bi-pencil-square fs-4 text-center bg-warning px-1 rounded" style="color: dark;"></i></a>
                        <a href="supprimer_filiere?id=<?= htmlspecialchars($filiere['id']) ?>" class="" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')"><i class="bi bi-trash fs-4 bg-danger px-1 rounded" style="color: white;margin-left:13px;"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="ajouter_filiere" class="btn btn-primary"><i class="bi bi-clipboard-plus text-white"></i> Ajouter une filière</a>
</div>
<?php require 'admin_bottom.php' ?>