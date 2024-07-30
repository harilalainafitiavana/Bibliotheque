<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $study_year = $_POST['study_year'];

    $sql = 'INSERT INTO filieres (name, description, study_year) VALUES (:name, :description, :study_year)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':study_year', $study_year);
    $stmt->execute();

    header('Location: filieres');
}

require 'admin_top.php';
?>

<div class="container w-100 border border-2 shadow rounded-4 mt-3">
    <h2 class="text-center mt-1" style="color: #21D192;">Ajouter une filière</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label text-primary fs-6">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label text-primary fs-6">Description</label>
            <textarea name="description" id="description" class="form-control" rows="10" required></textarea>
        </div>
        <div class="mb-3">
            <label for="study_year" class="form-label text-primary fs-6">Study Year</label>
            <select name="study_year" id="study_year" class="form-control" required>
                <option value="L3">Licence</option>
                <option value="M2">Master</option>
                <option value="Doctorat">Doctorat</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100 mb-3">Ajouter</button>
    </form>
</div>

<?php require 'admin_bottom.php' ?>
