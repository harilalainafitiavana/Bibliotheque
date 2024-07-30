<?php
session_start();

$path = '../../';

require_once '../functions.php';
login_required($path);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photo = $_FILES['photo'];

    if ($photo['error'] !== UPLOAD_ERR_OK) {
        $erreur = "Une erreur s'est produite lors du téléchargement de la photo.";
    } else {
        $maxFileSize = 5 * 1024 * 1024; // 5 Mo
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if ($photo['size'] > $maxFileSize) {
            $erreur = "La taille de la photo ne doit pas dépasser 5 Mo.";
        } elseif (!in_array($photo['type'], $allowedMimeTypes)) {
            $erreur = "Le format de la photo n'est pas valide. Seuls les formats JPEG, PNG et GIF sont acceptés.";
        } else {
            // Déplacer la photo vers le répertoire de destination
            $targetDir = $path . "uploads/photos/";
            $targetFile = $targetDir . basename($photo['name']);
            move_uploaded_file($photo['tmp_name'], $targetFile);
            $targetPath = "uploads/photos/" . basename($photo['name']);

            // Enregistrer l'utilisateur dans la base de données
            require "../config.php";

            $sql = "UPDATE utilisateurs SET photo = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$targetPath, $_SESSION['user_id']]);

            if ($stmt->rowCount() > 0) {
                header("Location: inscription_date");

                $_SESSION["user_photo"] = $targetPath;

                exit();
            } else {
                $erreur = "Erreur d'inscription : " . $stmt->errorInfo()[2];
            }

            $conn = null;
        }
    }
}

require '../partials/header.php';
require '../partials/form_top.php';
?>

<form action="inscription_photo" method="POST" class="login_form" enctype="multipart/form-data">
    <img src="../../images/logo-cnre.png" alt="photo" class="mt-0" style="width: 100px; margin-inline: auto; margin-bottom: 30px;">
    <h4 class="text-center">Photo de <?php echo $_SESSION['username'] ?></h4>
    <?php if (isset($erreur)) : ?>
        <p style="color: red; font-size: 14px; margin-top: 0px; margin-bottom:-8px; text-align: center;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <p class="link">Vous pouvez ajouter un photo de profile à votre compte.</p>
    <div class="py-2">
        <label for="photo" class="form-label text-white">Choisir votre photo:</label>
        <input type="file" name="photo" id='photo' class="form-control btn btn-success w-100 outline-none border-none shadow-none" required autofocus>
    </div>
    <button type="submit" class="btn btn-primary mt-3 w-100">Suivant</button>
    <p class="link"><a href="inscription_date">Ignorer</a></p>
</form>

<?php
require '../partials/form_bottom.php';
require '../partials/footer.php';
?>