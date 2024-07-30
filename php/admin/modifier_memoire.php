<?php
require_once '../config.php';

$path = '../../';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $universite = $_POST['universite'];
    $author = $_POST['author'];
    $id_filiere = $_POST['id_filiere'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $target_dir = $path . 'uploads/memoires/';
        $target_file = $target_dir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
        $target_path = 'uploads/memoires/' . basename($_FILES['file']['name']);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = $path . 'uploads/couverture/';
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $target_photo = 'uploads/couverture/' . basename($_FILES['image']['name']);
    } else {
        $target_photo = null; // Si aucune photo n'a été téléchargée, on définit la valeur à null
    }

    $sql = 'UPDATE memoires SET title = :title, description = :description, universite = :universite, file = :file, image = :image, author = :author, id_filiere = :id_filiere WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':universite', $universite);
    $stmt->bindParam(':file', $target_path, PDO::PARAM_STR);
    $stmt->bindParam(':image', $target_photo, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':id_filiere', $id_filiere, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: memoires');
}

$sql = 'SELECT * FROM memoires WHERE id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$memoire = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM filieres';
$stmt = $conn->query($sql);
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'admin_top.php';
?>

<div class="container w-100 border border-2 shadow rounded-4 mt-3">
    <h2 class="text-center mt-1" style="color: #21D192;">Modifier une mémoire</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label text-primary fs-6">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($memoire['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label text-primary fs-6">Résumer</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($memoire['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="universite" class="form-label text-primary fs-6">Universite</label>
            <input type="text" class="form-control" id="universite" name="universite" value="<?= htmlspecialchars($memoire['universite']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label text-primary fs-6">Fichier</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <div class="mb-3">
            <label for="author" class="form-label text-primary fs-6">Auteur</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($memoire['author']) ?>" required>
        </div>
        <div class="mb-3">
            <?php if ($memoire['image']) : ?>
                <img src="<?= "../../" . htmlspecialchars($memoire['image']) ?>" width="100">
            <?php endif; ?>
            <label for="image" class="form-label text-primary fs-6">Couverture</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="id_filiere" class="form-label text-primary fs-6">Filière</label>
            <select class="form-select" id="id_filiere" name="id_filiere" required>
                <?php foreach ($filieres as $filiere) : ?>
                    <option value="<?= htmlspecialchars($filiere['id']) ?>" <?= $filiere['id'] == $memoire['id_filiere'] ? 'selected' : '' ?>><?= htmlspecialchars($filiere['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Modifier</button>
    </form>
</div>
<?php require 'admin_bottom.php'; ?>