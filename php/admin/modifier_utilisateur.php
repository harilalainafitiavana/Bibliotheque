<?php
require_once '../config.php';

$path = '..\\..\\';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $num = $_POST['num'];
    $admin = isset($_POST['admin']) ? 1 : 0;
    $birth_date = $_POST['birth_date'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = $path . 'uploads/photos/';
        $target_file = $target_dir . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
        $target_path = 'uploads/photos/' . basename($_FILES['photo']['name']);

        $sql = 'UPDATE utilisateurs SET username = :username, email = :email, num = :num, admin = :admin, birth_date = :birth_date, photo = :photo WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':photo', $target_path, PDO::PARAM_STR);
    } else {
        $sql = 'UPDATE utilisateurs SET username = :username, email = :email, num = :num, admin = :admin, birth_date = :birth_date WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);
        $stmt->bindParam(':birth_date', $birth_date);
    }

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: utilisateurs');
}

$sql = 'SELECT * FROM utilisateurs WHERE id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
require 'admin_top.php';
?>

<div class="container w-100 border border-2 shadow rounded-4 mt-3">
    <h2 class="text-center mt-1" style="color: #21D192;">Modifier une utilisateur</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label text-primary fs-6">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($utilisateur['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-primary fs-6">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="num" class="form-label text-primary fs-6">Tel</label>
            <input type="text" class="form-control" id="num" name="num" value="<?= htmlspecialchars($utilisateur['num']) ?>" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="admin" name="admin" <?= $utilisateur['admin'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="admin">Admin</label>
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label text-primary fs-6">Date de naissance</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?= htmlspecialchars($utilisateur['birth_date']) ?>" required>
        </div>
        <div class="mb-3">
            <?php if ($utilisateur['photo']) : ?>
                <img src="<?= "../../" . htmlspecialchars($utilisateur['photo']) ?>" width="100">
            <?php endif; ?>
            <label for="photo" class="form-label text-primary fs-6">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Modifier</button>
    </form>
</div>

<?php require 'admin_bottom.php'; ?>