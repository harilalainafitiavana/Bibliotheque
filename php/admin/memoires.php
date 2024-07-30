<?php
require_once '../config.php';

$sql = 'SELECT m.*, f.name AS filiere_name FROM memoires m INNER JOIN filieres f ON m.id_filiere = f.id';
$stmt = $conn->query($sql);
$memoires = $stmt->fetchAll(PDO::FETCH_ASSOC);
require 'admin_top.php';
?>

    <div>
        <h1 class="text-center fs-1 mt-4 mb-3" style="color: #21D192;">Liste des mémoires</h1>
        <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th style="  background-color: #21D192; color:white;">ID</th>
                    <th style="  background-color: #21D192; color:white;">Titre</th>
                    <th style="  background-color: #21D192; color:white;">Résumer</th>
                    <th style="  background-color: #21D192; color:white;">Universite</th>
                    <th style="  background-color: #21D192; color:white;">Auteur</th>
                    <th style="  background-color: #21D192; color:white;">Filière</th>
                    <th style="  background-color: #21D192; color:white;">Couverture</th>
                    <th style="  background-color: #21D192; color:white;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($memoires as $memoire) : ?>
                    <tr>
                        <td><?= htmlspecialchars($memoire['id']) ?></td>
                        <td><?= htmlspecialchars($memoire['title']) ?></td>
                        <td><?= htmlspecialchars($memoire['description']) ?></td>
                        <td><?= htmlspecialchars($memoire['universite']) ?></td>
                        <td><?= htmlspecialchars($memoire['author']) ?></td>
                        <td><?= htmlspecialchars($memoire['filiere_name']) ?></td>
                        <td>
                            <?php if ($memoire['image']) : ?>
                                <img src="<?= "../../" . htmlspecialchars($memoire['image']) ?>" width="40">
                            <?php endif; ?>
                        </td>
                        <td class="d-flex">
                            <a href="modifier_memoire?id=<?= htmlspecialchars($memoire['id']) ?>" class=""><i class="bi bi-pencil-square fs-4 text-center bg-warning px-1 rounded" style="color: dark;"></i></a>
                            <a href="supprimer_memoire?id=<?= htmlspecialchars($memoire['id']) ?>" class="" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mémoire ?')"><i class="bi bi-trash fs-4 bg-danger px-1 rounded" style="color: white;margin-left:10px;"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="ajouter_memoire" class="btn btn-primary"><i class="bi bi-clipboard-plus text-white"></i> Ajouter un mémoire</a>
    </div>
    
<?php require 'admin_bottom.php'; ?>
