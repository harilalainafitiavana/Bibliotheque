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
        // Récupérer la valeur de recherche (auteur ou titre)
        $searchValue = isset($_GET['search']) ? $_GET['search'] : '';

        // Requête pour récupérer les articles correspondant à la recherche
        $sql = "SELECT * FROM articles WHERE author LIKE :searchValue OR title LIKE :searchValue";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':searchValue', '%' . $searchValue . '%', PDO::PARAM_STR);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<body>
    <div class="container my-5">

        <h1 class="mt-0" style="color: #21D192;">Liste des articles</h1>
        <!-- Recherche -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group w-50">
                <input type="text" class="form-control bg-light outline-none shadow-none border-success" placeholder="Rechercher par auteur ou titre" name="search" value="<?php echo $searchValue; ?>">
                <button class="btn btn-primary" type="submit">Rechercher</button>
            </div>
        </form>

        <div class="row">
            <?php foreach ($articles as $article) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-dark">
                    <div class="card-body">
                        <h5 class="card-title text-center text-success"><?php echo $article['title']; ?></h5>
                        <hr style="border: 1px solid black;">
                        <!-- <p class="card-text"><?php echo $article['description']; ?></p> -->
                        <p class="card-text"><strong>Auteur :</strong> <?php echo $article['author']; ?></p>
                    </div>
                </div>                
                <a href="description_article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary mt-2">Voir plus</a>
            </div>
            <?php } ?>
        </div>
    </div>

<?php require 'php/partials/footer.php'; ?>