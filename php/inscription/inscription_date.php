<?php
session_start();

$path = '../../';

require_once '../functions.php';
login_required($path);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birth_date = $_POST['birth_date'];

    require "../config.php";

    $sql = "UPDATE utilisateurs SET birth_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$birth_date, $_SESSION['user_id']]);

    if ($stmt->rowCount() > 0) {
        header("Location: " . $path . "index");
        $_SESSION["birth_date"] = $birth_date;
        exit();
    } else {
        $erreur = "Erreur d'enregistrement de date de naissance : " . $stmt->errorInfo()[2];
    }

    $conn = null;
}

include '../partials/header.php';
require '../partials/form_top.php';
?>

<form action="inscription_date" method="POST" class="login_form">
    <img src="../../images/logo-cnre.png" alt="photo" class="mt-0" style="width: 100px; margin-inline: auto; margin-bottom: 30px;">
    <h4 class="text-center">Date de naissance de <?php echo $_SESSION['username'] ?></h4>
    <?php if (isset($erreur)) : ?>
        <p style="color: red; font-size: 14px; margin-top: 0px; margin-bottom:-8px; text-align: center;"><?php echo $erreur; ?></p>
    <?php endif; ?>
    <p class="link">Vous pouvez ajouter date de naissance à votre compte.</p>
    <div class="py-2">
        <label for="birth_date" class="form-label text-white">Date de naissance:</label>
        <input type="date" name="birth_date" id='birth_date' class="form-control w-100 outline-none border-none shadow-none" required autofocus>
    </div>
    <button type="submit" class="btn btn-primary mt-3 w-100">Suivant</button>
    <p class="link"><a href="<?php echo $path ?>index">Terminer</a></p>
</form>

<?php
require '../partials/footer.php';
require '../partials/form_bottom.php';
?>