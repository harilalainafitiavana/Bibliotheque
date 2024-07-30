<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "cnre";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Démarrer la session
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../index"); // Redirigez vers la page de connexion
        exit;
    }

    // Récupérer les articles de l'utilisateur connecté
    $sql = "SELECT * FROM articles WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fermer la connexion
    $stmt = null;
    $conn = null;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
require 'admin_top.php';
?>

    <div class="container my-3">
        <h1  class="text-center mt-0 mb-3 fs-1" style="color: #21D192;">Liste des articles</h1>
        <table class="table table-striped">
            <thead>
                <tr class="highlight">
                    <th style="  background-color: #21D192; color:white;">Titre</th>
                    <th style="  background-color: #21D192; color:white;">Auteur</th>
                    <th style="  background-color: #21D192; color:white;">Description</th>
                    <th style="  background-color: #21D192; color:white;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) { ?>
                <tr>
                    <td><?php echo $article['title']; ?></td>
                    <td><?php echo $article['author']; ?></td>
                    <td><?php echo $article['description']; ?></td>
                    <td class="d-flex">
                        <a href="modifier_article?id=<?= htmlspecialchars($article['id']) ?>" class=""><i class="bi bi-pencil-square fs-5 text-center bg-warning px-2 py-1 rounded" style="color: dark;"></i></a>
                        <a href="supprimer_articles?id=<?= htmlspecialchars($article['id']) ?>" class=""onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')"><i class="bi bi-trash fs-5 bg-danger px-2 py-1 rounded" style="color: white;margin-left:12px;"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="ajouter_articles" class="btn btn-primary"><i class="bi bi-clipboard-plus text-white"></i> Ajouter une article</a>
    </div>
    
    <?php require 'admin_bottom.php'; ?>