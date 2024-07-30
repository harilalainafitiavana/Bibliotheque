<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "cnre";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        // Récupérer l'ID de l'article à afficher
        $articleId = $_GET['id'];

        // Requête pour récupérer les détails de l'article
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Rediriger l'utilisateur vers la page de connexion
        header("Location: login.php");
        exit;
    }

    // Fermer la connexion
    $stmt = null;
    $conn = null;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$path = '';
require 'php/partials/header.php';
?>

<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center" style="color: #000;"><?php echo $article['title']; ?></h2>
            <hr>
            <div class='d-flex'>
                <p class="card-text w-25"><span class="text-danger">Auteur : </span><?php echo $article['author']; ?></p>
                <p class="card-text w-75"><?php echo $article['description']; ?></p>
            </div>
            <a href="php/get_article_file.php?id=<?php echo $article['id']; ?>" class="btn btn-primary mt-2 w-25">Télécharger</a>
        </div>
    </div>
</div>

<?php require 'php/partials/footer.php'; ?>