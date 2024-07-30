<?php
require_once '../config.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = 'UPDATE filieres SET name = :name, description = :description WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmt->execute();

    header('Location: filieres');
}

$sql = 'SELECT * FROM filieres WHERE id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$filiere = $stmt->fetch(PDO::FETCH_ASSOC);

require 'admin_top.php';
?>

<div class="container w-100 border border-2 shadow rounded-4 mt-3">
    <h2 class="text-center mt-1" style="color: #21D192;">Modifier filière</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label text-primary fs-6">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($filiere['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label text-primary fs-6">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($filiere['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Modifier</button>
    </form>
</div>

<?php require 'admin_bottom.php'; ?>