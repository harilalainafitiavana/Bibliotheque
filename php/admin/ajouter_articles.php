<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "cnre";
$path = '../../';
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

    // Initialiser les variables
    $title = "";
    $author = "";
    $description = "";
    $errorMessage = "";
    $user_id = $_SESSION['user_id'];
    $target_path = null;

    // Récupérer les données du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $file = $_FILES['file'];

        if (isset($file) && $file['error'] === UPLOAD_ERR_OK && !empty($file['name'])) {
            $target_dir = $path . 'uploads/articles/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true); // Créer le dossier s'il n'existe pas
            }
            $target_file = $target_dir . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $target_path = $target_file;
            } else {
                $errorMessage = "Erreur lors du téléchargement du fichier.";
            }
        }
        
        // Préparer la requête SQL
        $sql = "INSERT INTO articles (title, author, file, description, user_id) VALUES (:title, :author, :file, :description, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':file', $target_path); // Correction : passer la variable $target_path
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            header('Location: articles');
        } else {
            $errorMessage = "Erreur lors de l'ajout de l'article : " . $stmt->errorInfo()[2];
        }

        // Fermer la connexion
        $stmt = null;
        $conn = null;
    }
} catch (PDOException $e) {
    $errorMessage = "Erreur : " . $e->getMessage();
}

require 'admin_top.php';
?>

  <div class="container Mb-4">
    <h1 class="text-center mb-4">Ajouter un article</h1>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="book-item">
          <img src="../../images/Silent Forest 2.gif" alt="Livre">
          <div class="add-book-btn">
            <i class="bi bi-plus-square fs-5"></i>
          </div>
          <div class="book-details">
            <form id="add-book-form" method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                <label for="bookTitle" class="fs-5 text-white">Titre de l'article</label>
                <input type="text" class="form-control" id="bookTitle" name="title" placeholder=".........................." required>
              </div>
              <div class="form-group">
                <label for="bookDescription" class="fs-5 text-white">Description de l'article</label>
                <textarea class="form-control" id="bookDescription" name="description" rows="3" placeholder="Entrez la description du livre ou résumer" required></textarea>
              </div>
              <div class="form-group">
                <label for="bookFile" class="fs-5 text-white">Fichier</label>
                <input type="file" class="form-control" id="bookFile" name="file"  required>
              </div>
              <div class="form-group">
                <label for="bookAuthor" class="fs-5 text-white">Auteur de l'article</label>
                <input type="text" class="form-control" id="bookAuthor" name="author" placeholder=".........................."  required>
              </div>
              <button type="submit" class="btn btn-primary mt-2">Ajouter un article</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require 'admin_bottom.php' ?>
