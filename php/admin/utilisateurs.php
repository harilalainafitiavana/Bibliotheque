<?php
require_once '../config.php';

$sql = 'SELECT * FROM utilisateurs';
$stmt = $conn->query($sql);
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'admin_top.php';
?>

    <div>
        <h1 class="text-center fs-1 mt-4 mb-4 text-secondary">Liste des utilisateurs</h1>
        <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th style="  background-color: #21D192; color:white;">ID</th>
                    <th style="  background-color: #21D192; color:white;">Nom d'utilisateur</th>
                    <th style="  background-color: #21D192; color:white;">Email</th>
                    <th style="  background-color: #21D192; color:white;">Tel</th>
                    <th style="  background-color: #21D192; color:white;">Admin</th>
                    <th style="  background-color: #21D192; color:white;">Date d'inscription</th>
                    <th style="  background-color: #21D192; color:white;">Date de naissance</th>
                    <th style="  background-color: #21D192; color:white;">Photo</th>
                    <th style="  background-color: #21D192; color:white;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur) : ?>
                    <tr>
                        <td><?= htmlspecialchars($utilisateur['id']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['username']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['num']) ?></td>
                        <td><?= $utilisateur['admin'] ? 'Oui' : 'Non' ?></td>
                        <td><?= htmlspecialchars($utilisateur['date_join']) ?></td>
                        <td><?= htmlspecialchars($utilisateur['birth_date']) ?></td>
                        <td>
                            <?php if ($utilisateur['photo']) : ?>
                                <img src="<?= "../../" . htmlspecialchars($utilisateur['photo']) ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a style="max-width: 30px; display: inline-block;" href="modifier_utilisateur?id=<?= htmlspecialchars($utilisateur['id']) ?>"><i class="bi bi-pencil-square fs-4 text-center bg-warning px-1 rounded" style="color: dark;"></i></a>
                            <a style="max-width: 30px; display: inline-block;"  href="supprimer_utilisateur?id=<?= htmlspecialchars($utilisateur['id']) ?>"onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"><i class="bi bi-trash fs-4 bg-danger px-1 rounded" style="color: white;margin-left:5px;"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php include 'admin_bottom.php'; ?>