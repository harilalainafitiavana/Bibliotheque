
<?php

    $path = '';
    include 'php/config.php';
    session_start();

    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        

        // Traitement du formulaire de modification du profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $num = $_POST['num'];
            $birth_date = $_POST['birth_date'];

            // Traitement de la photo de profil
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $target_dir = $path . 'uploads/photo/';
                $target_file = $target_dir . basename($_FILES['photo']['name']);
                move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
                $target_path = 'uploads/photos/' . basename($_FILES['photo']['name']);


                $sql = 'UPDATE utilisateurs SET username = :username, email = :email, num = :num, birth_date = :birth_date, photo = :photo WHERE id = :id';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':num', $num);
                $stmt->bindParam(':birth_date', $birth_date);
                $stmt->bindParam(':photo', $target_path,PDO::PARAM_STR);

            } else {
                $sql = 'UPDATE utilisateurs SET username = :username, email = :email, num = :num, birth_date = :birth_date WHERE id = :id';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':num', $num);
                $stmt->bindParam(':birth_date', $birth_date);
            }

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        
            header('Location: home');
        }

        $sql = 'SELECT * FROM utilisateurs WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        $path = "";

        require 'php/partials/header.php';

?>

<div class="container w-10 border border-2 shadow rounded-4 mt-5 mb-4">
    <h2 class="text-center mt-2" style="color: #21D192;">Vous pouvez modifié votre profile</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label text-primary">Nom d'utilisateur</label>
            <input type="text" class="form-control outline-none border-none shadow-none" id="username" name="username" value="<?= htmlspecialchars($utilisateur['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-primary">Email</label>
            <input type="email" class="form-control outline-none border-none shadow-none" id="email" name="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="num" class="form-label text-primary">Tel</label>
            <input type="text" class="form-control outline-none border-none shadow-none" id="num" name="num" value="<?= htmlspecialchars($utilisateur['num']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="birth_date" class="form-label text-primary">Date de naissance</label>
            <input type="date" class="form-control outline-none border-none shadow-none" id="birth_date" name="birth_date" value="<?= htmlspecialchars($utilisateur['birth_date']) ?>">
        </div>
        <p class="text-center text-danger">" Aprés votre modification, veuillez déconnecté et reconnecté pour que nous puissions mettre à jour votre profile ! "</p>
        <div class="mb-3 mt-3">
            <?php if ($utilisateur['photo']) : ?>
                <img src="<?=htmlspecialchars($utilisateur['photo']) ?>" width="100">
            <?php endif; ?>
            <label for="photo" class="form-label text-primary">Photo</label>
            <input type="file" class="form-control outline-none border-none shadow-none" id="photo" name="photo">
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Modifier</button>
    </form>
</div>

<?php   
  } else {
    echo "vous devez connecté pour acceder à cette page";
  }
?>

<?php require 'php/partials/footer.php'; ?>