<?php
// Connexion à la base de données

$conn = new mysqli("localhost", "root", "", "cnre");

// Traitement du formulaire de réinitialisation de mot de passe
if(isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST['email']);

    // Vérifier si l'e-mail existe dans la base de données
    $query = "SELECT * FROM utilisateurs WHERE email='$email'";
    $result = $conn->query($query);

    if($result->num_rows == 1) {
        // Générer un nouveau mot de passe aléatoire
        $new_password = bin2hex(random_bytes(8)); // Génération d'un mot de passe de 8 caractères aléatoires

        // Hasher le nouveau mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $update_query = "UPDATE utilisateurs SET password ='$hashed_password' WHERE email='$email'";
        $conn->query($update_query);

        // Envoyer le nouveau mot de passe à l'utilisateur par e-mail
        $to = $email;
        $subject = 'Réinitialisation de mot de passe';
        $message = 'Votre nouveau mot de passe est : ' . $new_password;
        $headers = 'From: votreadresse@mail.com' . "\r\n" .
            'Reply-To: votreadresse@mail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        echo "Un nouveau mot de passe a été envoyé à votre adresse e-mail enregistrée.";
    } else {
        echo "Aucun compte associé à cette adresse e-mail.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h2>Réinitialisation de mot de passe</h2>
    <form method="post" action="">
        <label for="email">Entrez votre adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" name="submit" value="Réinitialiser le mot de passe">
    </form>
    <a href="index.php">Retour vers le connexion</a>
</body>
</html>
