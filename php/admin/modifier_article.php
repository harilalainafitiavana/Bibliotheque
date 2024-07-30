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
        header("Location: ../../index");
        exit;
    }

    // Initialiser les variables
    $errorMessage = "";
    $user_id = $_SESSION['user_id'];

    // Récupérer l'article à modifier
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM articles WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$article) {
            $errorMessage = "Cet article n'existe pas ou vous n'êtes pas autorisé à le modifier.";
        } else {
            $title = $article['title'];
            $author = $article['author'];
            $description = $article['description'];
            $file = $article['file'];
        }
    }

    // Traiter le formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
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
        } else {
            $target_path = $file;
        }

        // Préparer la requête SQL
        $sql = "UPDATE articles SET title = :title, author = :author, file = :file, description = :description WHERE id = :id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':file', $target_path);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            header('Location: articles');
        } else {
            $errorMessage = "Erreur lors de la modification de l'article : " . $stmt->errorInfo()[2];
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

    <div class="container w-100 border border-2 shadow rounded-4 mt-3">
        <h1 class="text-center mt-1" style="color: #21D192;">Modifier un article</h1>

        <?php if (!empty($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($article) ? $article['id'] : ''; ?>">
            <div class="form-group">
                <label for="title" class="form-label text-primary fs-6">Titre :</label>
                <input type="text" class="form-control" id="title" name="title" required value="<?php echo $title; ?>">
            </div>
            <div class="form-group">
                <label for="author" class="form-label text-primary fs-6">Auteur :</label>
                <input type="text" class="form-control" id="author" name="author" required value="<?php echo $author; ?>">
            </div>
            <div class="form-group">
                <label for="description" class="form-label text-primary fs-6">Description :</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="file" class="form-label text-primary fs-6 mt-2">Fichier</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-success w-100 mt-3 mb-3">Enregistrer</button>
        </form>
    </div>

<?php require 'admin_bottom.php' ?>