<?php
session_start();

$path = '../../';

if (isset($_SESSION['user_id'])) {
    header('Location: ../../home');
    exit();
}

if (isset($_POST['username'])) {
    $erreur = "Vous avez déjà soumis le formulaire d'inscription.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];

    if ($username == "" || $password == "" || $confirm_password == "") {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif ($password != $confirm_password) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 8) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $erreur = "Le mot de passe doit contenir au moins un chiffre.";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $erreur = "Le mot de passe doit contenir au moins une lettre minuscule.";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $erreur = "Le mot de passe doit contenir au moins une lettre majuscule.";
    } elseif (!preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password)) {
        $erreur = "Le mot de passe doit contenir au moins un caractère spécial.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        require "../config.php";

        $sql = "SELECT * FROM utilisateurs WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $erreur = "Ce nom d'utilisateur est déjà utilisé.";
        } else {
            $sql = "INSERT INTO utilisateurs (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $hashed_password]);

            if ($stmt->rowCount() > 0) {
                require "../functions.php";
                $user = get_user_by_name($conn, $username);

                header("Location: inscription_email.php");

                $_SESSION["username"] = $user["username"];
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["admin"] = $user["admin"];
            } else {
                $erreur = "Erreur d'inscription : " . $stmt->errorInfo()[2];
            }

            $conn = null;
            exit();
        }
    }
}

require '../partials/header.php';
require '../partials/form_top.php';
?>

<form action="inscription_nom_mdp" method="POST" class="login_form">
    <img src="<?php echo $path . 'images/logo-cnre.png' ?>" alt="photo" class="mt-0" style="width: 100px; margin-inline: auto; margin-bottom: 30px;">
    <h2>Inscription</h2>
    <?php if (isset($erreur)) : ?>
        <p style="color: red; font-size: 14px; margin-top: 0px; margin-bottom:-8px; text-align: center;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <div class="inputBox" >
        <input type="text" required="required" name="username" autofocus>
        <span><i class="bi bi-person-fill"></i>Nom de votre compte: </span>
        <i class="i"></i>
    </div>
    <div class="inputBox">
        <input type="password" required="required" name="password">
        <span><i class="bi bi-lock-fill"></i> Votre Mot de passe: </span>
        <i class="i"></i>
    </div>
    <div class="inputBox">
        <input type="password" required="required" name="password_confirm">
        <span><i class="bi bi-lock-fill"></i> Confirmation du Mot de passe: </span>
        <i class="i"></i>
    </div>
    <input type="submit" class="form_button" value="S'inscrire">
</form>

<?php
require '../partials/form_bottom.php';
require '../partials/footer.php';
?>