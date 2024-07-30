<?php

  require_once '../config.php';

  $path = '../../';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $universite = $_POST['universite'];
    $file = $_FILES['file'];
    $author = $_POST['author'];
    $id_filiere = $_POST['id_filiere'];

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK && !empty($file['name'])) {
        $target_dir = $path . 'uploads/memoires/';
        $target_file = $target_dir . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $target_file);
        $target_path = 'uploads/memoires/' . basename($file['name']);
    } else {
        $target_path = null;
    }
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = $path . 'uploads/couverture/';
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $target_path_image = 'uploads/couverture/' . basename($_FILES['image']['name']);
    } else {
        $target_path_image = null;
    }

    $sql = 'INSERT INTO memoires (title, description, universite, file, author, id_filiere, image) VALUES (:title, :description, :universite, :file, :author, :id_filiere, :image)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':universite', $universite);
    $stmt->bindParam(':file', $target_path, PDO::PARAM_STR | PDO::PARAM_NULL);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':id_filiere', $id_filiere, PDO::PARAM_INT);
    $stmt->bindParam(':image', $target_path_image, PDO::PARAM_STR | PDO::PARAM_NULL);
    $stmt->execute();

    header('Location: memoires');
}

$sql = 'SELECT * FROM filieres';
$stmt = $conn->query($sql);
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'admin_top.php';
?>

  <div class="container Mb-4">
    <h1 class="text-center mb-4">Ajouter un livre</h1>
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
                <label for="bookTitle" class="fs-5 text-white">Titre du livre</label>
                <input type="text" class="form-control" id="bookTitle" name="title" placeholder=".........................." required>
              </div>
              <div class="form-group">
                <label for="bookDescription" class="fs-5 text-white">Description du livre</label>
                <textarea class="form-control" id="bookDescription" name="description" rows="3" placeholder="Entrez la description du livre ou résumer" required></textarea>
              </div>
              <div class="form-group">
                <label for="bookUniversity" class="fs-5 text-white">Université</label>
                <input type="text" class="form-control" id="bookUniversity" name="universite" placeholder=".........................."  required>
              </div>
              <div class="form-group">
                <label for="bookFile" class="fs-5 text-white">Fichier</label>
                <input type="file" class="form-control" id="bookFile" name="file"  required>
              </div>
              <div class="form-group">
                <label for="bookAuthor" class="fs-5 text-white">Auteur</label>
                <input type="text" class="form-control" id="bookAuthor" name="author" placeholder=".........................."  required>
              </div>
              <div class="form-group">
                <label for="bookCover" class="fs-5 text-white">Couverture</label>
                <input type="file" class="form-control" id="bookCover" name="image" required>
              </div>
              <div class="form-group">
                <label for="bookDepartment" class="fs-5 text-white">Filière</label>
                <select class="form-select" id="id_filiere" name="id_filiere" required>
                  <?php foreach ($filieres as $filiere) : ?>
                      <option value="<?= htmlspecialchars($filiere['id']) ?>"><?= htmlspecialchars($filiere['name']) ?></option>
                  <?php endforeach; ?>
              </select>
              </div>
              <button type="submit" class="btn btn-primary mt-2">Ajouter le livre</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require 'admin_bottom.php' ?>
