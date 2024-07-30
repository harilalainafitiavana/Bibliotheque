<?php
session_start();

$path = '../../';

require_once '../functions.php';
login_required($path);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $num = $_POST['num'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Veuillez entrer une adresse email valide.";
    } else {
        require "../config.php";

        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $erreur = "Cet adresse email est déjà utilisé.";
        } else {

            $sql = "UPDATE utilisateurs SET email = ?, num = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $num, $_SESSION['user_id']]);

            if ($stmt->rowCount() > 0) {
                header("Location: inscription_photo");

                $_SESSION["email"] = $email;
                $_SESSION['num'] = $num;

                exit();
            } else {
                $erreur = "Erreur d'enregistrement d'adresse email : " . $stmt->errorInfo()[2];
            }
        }

        $conn = null;
    }
}

include '../partials/header.php';
include '../partials/form_top.php';
?>

<form action="inscription_email" method="POST" class="login_form">
    <img src="../../images/logo-cnre.png" alt="photo" class="mt-0" style="width: 100px; margin-inline: auto; margin-bottom: 30px;">
    <h4 class="text-center">Email de <?php echo $_SESSION['username'] ?></h4>
    <?php if (isset($erreur)) : ?>
        <p style="color: red; font-size: 14px; margin-top: 0px; margin-bottom:-8px; text-align: center;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <p class="link">Nous avons besoin de votre adresse email pour les notification et la réinitialisation de mot de passe.</p>

    <div class="inputBox">
        <input type="email" required="required" name="email" autofocus>
        <span>Votre email: </span>
        <i class="i"></i>
    </div>

    <div class="inputBox">
        <input type="text" name="num" required>
        <span>Votre numero de telephone: </span>
        <i class="i"></i>
    </div>
    <button type="submit" class="btn btn-primary mt-3 w-100">Suivant</button>
</form>

<?php
include '../partials/form_bottom.php';
include '../partials/footer.php';
?>