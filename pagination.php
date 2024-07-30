<?php
$conn = new PDO("mysql:host=<hostname>;dbname=<database>", "<username>", "<password>");

// Nombre de résultats par page
$results_per_page = 6;

// Calculer le nombre total de résultats
$stmt = $conn->query("SELECT COUNT(*) FROM filieres");
$total_results = $stmt->fetchColumn();

// Calculer le nombre total de pages
$total_pages = ceil($total_results / $results_per_page);

// Vérifier si la page demandée est valide
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $total_pages ? $_GET['page'] : 1;

// Calculer l'offset pour la clause LIMIT
$offset = ($page - 1) * $results_per_page;

// Récupérer les résultats pour la page actuelle
$stmt = $conn->prepare("SELECT * FROM filieres LIMIT :offset, :results_per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les résultats
foreach ($results as $row) {
    // Afficher les données de la ligne
}

// Afficher les liens de pagination
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "$i ";
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}


// HTML
// <div class="mb-3">
//             <label for="description" class="form-label">Description</label>
//             <textarea class="form-control outline-none border-none shadow-none" id="description" name="description" rows="3" required><?= htmlspecialchars($memoire['description']) ?></textarea>
// </div>


<a style="max-width: 50px; display: inline-block; float: right;" href="ajouter_utilisateur"><?php include '../../icons/user-add.svg' ?></a>