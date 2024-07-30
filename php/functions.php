<?php
// Verification du connexion 
function login_required($path)
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $path . 'index.php');
        exit();
    }
}
// Vérifier que si l'utilisateurs est un administrateur
function admin_required($path)
{
    if (!$_SESSION['admin']) {
        header('Location: ' . $path . 'index.php');
        exit();
    }
}
// Déconnexion
function logout($path)
{
    session_start();
    session_destroy();
    header('Location: ' . $path . 'index');
    exit();
}

// Sélectionner un utilisateur par son nom
function get_user_by_name($conn, $username)
{
    $sql = "SELECT * FROM utilisateurs WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

// Sélectionner tout les livres
function get_all_books($conn)
{
    $query = "SELECT m.*, f.name AS filiere_name, f.study_year AS filiere_study_year
    FROM memoires m
    INNER JOIN filieres f ON m.id_filiere = f.id";
    $stmt = $conn->query($query);
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $livres;
}

// Recherche livre
function search_book($conn, $query)
{
    $sql = "SELECT m.*, f.name AS filiere_name, f.study_year AS filiere_study_year
    FROM memoires m
    INNER JOIN filieres f ON m.id_filiere = f.id 
    WHERE m.title LIKE :search_term
        OR m.description LIKE :search_term
        OR m.author LIKE :search_term
        OR f.name LIKE :search_term
        OR f.description LIKE :search_term";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search_term', $query, PDO::PARAM_STR);
    $stmt->execute();

    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $livres;
}

// Recherche livre par année d'etude
function search_book_by_year($conn, $year)
{
    $sql = "SELECT m.*, f.name AS filiere_name, f.study_year AS filiere_study_year
    FROM memoires m
    INNER JOIN filieres f ON m.id_filiere = f.id  WHERE f.study_year LIKE :search_term";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search_term', $year, PDO::PARAM_STR);
    $stmt->execute();

    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $livres;
}

//Recherche par filière
function search_book_by_filiere($conn, $name)
{
    $sql = "SELECT m.*, f.name AS filiere_name, f.study_year AS filiere_study_year
    FROM memoires m
    INNER JOIN filieres f ON m.id_filiere = f.id  WHERE f.name LIKE :search_term";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search_term', $name, PDO::PARAM_STR);
    $stmt->execute();

    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $livres;
}

// Sélectionner tout les noms de filière unique
function get_filieres_names($conn)
{
    $sql = 'SELECT DISTINCT name FROM filieres';
    $stmt = $conn->query($sql);
    $filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $filieres;
}

// Sélectionner tout les filière
function get_all_filieres($conn)
{
    $sql = 'SELECT * FROM filieres';
    $stmt = $conn->query($sql);
    $filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $filieres;
}


function get_user_name($user_id) {
    // Code pour récupérer le nom de l'utilisateur à partir de la base de données ou d'une autre source
    $user_name = "John Doe"; // Remplacez par le code approprié
    return $user_name;
}






















