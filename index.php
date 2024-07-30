<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: home');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require 'php/config.php';

    $sql = "SELECT * FROM utilisateurs WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) == 1) {
        $row = $result[0];
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_num'] = $row['num'];
            $_SESSION['user_photo'] = $row['photo'];
            $_SESSION['admin'] = $row['admin'];
            header("Location: home");
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Nom d'utilisateur inconnu.";
    }

    $conn = null;
}

$path = "";

require 'php/partials/header.php';
require 'php/partials/form_top.php';
?>

<form action="" method="POST" class="login_form">
    <div style="max-width: 100px; margin: 5px auto;">
        <?php include $path . "icons/user.svg"; ?>
    </div>
    <h2>Connexion</h2>
    <?php if (isset($erreur)) : ?>
        <p style="color: red; font-size: 14px; margin-top: 0px; margin-bottom:-8px; text-align: center;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <div class="inputBox">
        <input type="text" required="required" name="username">
        <span><i class="bi bi-person-fill"></i> Nom</span>
        <i class="i"></i>
    </div>
    <div class="inputBox">
        <input type="password" required="required" name="password">
        <span><i class="bi bi-lock-fill"></i> Mot de passe</span>
        <i class="i"></i>
    </div>
    <div class="links">
        <a href="forgot_password">Mot de passe oublié?</a>
    </div>
    <input type="submit" class="form_button" value="Login" >

    <p class="link">Vous n'avez pas de compte?
        <a href="php/inscription/inscription">S'inscrire!</a>
    </p>
</form>

<?php
require 'php/partials/form_bottom.php';
require 'php/partials/footer.php';
?>