<?php
require_once '../config.php';

$path = '../../';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $num = $_POST['num'];
    $admin = isset($_POST['admin']) ? 1 : 0;
    $date_join = date('Y-m-d H:i:s');
    $birth_date = $_POST['birth_date'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = $path . 'uploads/photos/';
        $target_file = $target_dir . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
        $target_path = 'uploads/photos/' . basename($_FILES['photo']['name']);
    } else {
        $target_file = null;
    }

    $sql = 'INSERT INTO utilisateurs (username, password, email, num, admin, date_join, birth_date, photo) VALUES (:username, :password, :email, :num, :admin, :date_join, :birth_date, :photo)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':num', $num);
    $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);
    $stmt->bindParam(':date_join', $date_join);
    $stmt->bindParam(':birth_date', $birth_date);
    $stmt->bindParam(':photo', $target_path, PDO::PARAM_STR | PDO::PARAM_NULL);
    $stmt->execute();

    header('Location: utilisateurs');
}
require 'admin_top.php';
?>

<div class="container w-100 border border-2 shadow rounded-4 mt-3">
    <h2 class="text-center mt-1" style="color: #21D192;">Ajouter un utilisateur</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label text-primary fs-6">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-primary fs-6">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-primary fs-6">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="num" class="form-label text-primary fs-6">Tel</label>
            <input type="text" class="form-control" id="num" name="num" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="admin" name="admin">
            <label class="form-check-label" for="admin">Admin</label>
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label text-primary fs-6">Date de naissance</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label text-primary fs-6">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Ajouter</button>
    </form>
</div>
<?php require 'admin_bottom.php' ?>