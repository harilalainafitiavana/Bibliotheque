<?php
session_start(); // Démarrer la session
$path = '';
require_once 'php/functions.php';
require 'php/partials/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion s'il n'est pas connecté
    header("Location: index");
    exit(); // Arrêter l'exécution du script après la redirection
}

// Vérifier si l'identifiant du livre est présent dans l'URL
if(isset($_GET['id'])) {
    // Paramètres de connexion à la base de données 
    $servername = "localhost";
    $dbname = "cnre";
    $username = "root";
    $password = "";

    try {
        // Créer une connexion à la base de données avec PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Définir le mode d'erreur PDO sur exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la requête SQL pour récupérer les détails du livre spécifié par l'identifiant
        $livre_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM memoires WHERE id = :id");
        $stmt->bindParam(':id', $livre_id);
        $stmt->execute();

        // Vérifier s'il y a des résultats
        if ($stmt->rowCount() > 0) {
            // Récupérer les résultats
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $title = $row['title'];
            $description = $row['description'];
            $author = $row['author'];
            $universite = $row['universite'];
            $image_path = $row['image'];
            $file = $row['file'];
        } else {
            echo "Livre non trouvé";
        }
    } catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $conn = null;
}
?>
    <div class="container my-5 w-100 shadow border-1 p-5">
        <h2 class="mb-4 mt-0 text-success">Bibliothèque numérique du CNRE</h2>
        <div class="row d-flex align-items-center">
            <div class="col-md-6 mt-2 w-25">
                <img src="<?php echo $image_path; ?>" alt="Couverture" width="350" height="250" class="img-fluid rounded">
                <?php if(isset($title)) : ?>
                    <p class="mt-4"><strong class="text-primary">Auteur :</strong> <?php echo $author; ?></p>
                    <p class="mt-0"><strong class="text-primary">Universite :</strong> <?php echo $universite; ?></p>
                <?php else : ?>
                    <p>Aucun livre sélectionné.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-5 w-75">
                <?php if(isset($title)) : ?>
                    <h3 class="text-center"><?php echo $title; ?></h3>
                    <p><?php echo $description; ?></p>
                    <a href="<?php echo $file; ?>" class="btn btn-primary download-btn mt-5 px-5 py-1 w-50 fs-5" download="<?php echo $file; ?>"><i class="bi bi-arrow-down-circle fs-3"></i> Télecharger</a>
                <?php else : ?>
                    <p>Aucun livre sélectionné.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require 'php/partials/footer.php'; ?>


