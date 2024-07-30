<?php
$path = "";

include 'php/config.php';

include 'php/partials/form_top.php';


// Initialiser la variable $note
$note = '';

if (isset($_POST['email'])) {
    // Vérifier si l'e-mail existe dans la base de données
    $sql_check_email = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->execute([$_POST['email']]);
    $user = $stmt_check_email->fetch();

    if ($user) {
        $token = uniqid();
        $url = "http://localhost/cnreprojet/token?token=$token";

        $message = "Bonjour, voici votre lien pour la réinitialisation du mot de passe : $url";

        // Permet d'ajouter une mot avec accent
        $headers = 'Content-Type: text/plain; charset="utf-8" ' . " ";

        // Envoyer l'email avec le message 
        if (mail($_POST['email'], 'Mot de passe oublié', $message, $headers)) {
            $sql_update_token = "UPDATE utilisateurs SET token = ? WHERE email = ?";
            $stmt_update_token = $conn->prepare($sql_update_token);
            $stmt_update_token->execute([$token, $_POST['email']]);

            $note = "Votre email a été envoyé.";
        } else {
            $note = "Erreur lors de l'envoi de l'email.";
        }
    } else {
        $note = "Votre email n'existe pas, veuillez entrer une autre.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cnre</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
        <form action="" method="POST" class="">
            <h2 class="text-center text-dark mt-5 mb-3">Réinitialiser le mot de passe</h2>
            <?php if ($note) : ?>
                <p style="color: <?php echo ($note === 'Votre email a été envoyé.') ? 'green' : 'red'; ?>; font-size: 16px; margin-top: -8px; margin-bottom: 5px; text-align: center;"><?php echo htmlspecialchars($note); ?></p>
            <?php endif; ?>
            <span class="text-center mt-3"><i class="bi bi-envelope-fill"></i> Votre email :</span><br>
            <div class="inputBox d-flex align-items-center justify-content-center mb-5 mt-3">
                <input type="email" required="required" name="email" class="form-control outline-none border-2 shadow-none mx-2 w-100 rounded py-1 mb-5">
                <input type="submit" class="form_button w-25 py-1 rounded-3 text-white mb-5" value="Envoyer...." style="background: #21D192;">
            </div>
            <a href="index" class="btn btn-dark shadow-none text-white mt-5" style="padding: 3px 15px; text-decoration: none;">Retour vers la page connexion</a>
        </form>
</body>
</html>
