<?php

// Vérifier si la variable $user_id est définie
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0; // Valeur par défaut

}

// Vérifier si une session est déjà active
if (session_status() == PHP_SESSION_NONE) {
    // Démarrer la session
    session_start();
}

require_once '../functions.php';
admin_required('../../');
$path = "../../";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="dashboard/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../icons/bootstrap-icons/bootstrap-icons.css">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/animation.css">
    <link rel="stylesheet" href="../../css/css.css">

    <title>Dashboard admin</title>
</head>

<body class="min-vh-100">

    <header class="navbar navbar-dark sticky-top flex-md-nowrap justify-content-start p-0 w-100 py-1" style="background: #21D192 ">
        <a class="navbar-brand rounded-4 bg-light text-dark col-md-3 col-lg-2 me-0 px-3 fs-6 fw-bold text-center" href="#">MESUPRES</a>
        <ul class="px-4 list-unstyled m-0 d-flex gap-2">
            <li>
                <a href="../../home" title="Home">
                    <i class="bi bi-house-fill fs-3 text-dark bg-white px-1 rounded"></i>
                </a>
            </li>
            <li>
                <a href="../logout.php" title="Déconnexion" onclick="return confirm('Êtes-vous sûr de vouloir se déconnecté ?')">
                    <i class="bi bi-box-arrow-right fs-3 text-dark bg-danger px-1 rounded"></i>
                </a>
            </li>
            <li class=" dropdown">
                <a href="#" class="nav-icon pe-md-0" data-bs-toggle="dropdown">
                    <img src="<?php echo $path . $_SESSION['user_photo'] ?>" alt="" width="45px" height="45px" style="object-fit: cover; border-radius: 25px; margin-left: 69em; border: 3px solid white">
                    <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle" style="width: 10px; height: 10px;"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end rounded">
                    <a href="../../home" class="dropdown-item">
                        <i class="bi bi-house-door-fill me-2"></i>
                        <span>Accueil</span>
                    </a>
                    <a href="<?php echo $path ?>profiles" class="dropdown-item">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>Profiles</span>
                    </a>
                    <a href="../logout" class="dropdown-item" onclick="return confirm('Êtes-vous sûr de vouloir se déconnecté ?')">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </li>
        </ul>

        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </header>
    <main class="row position-relative min-vh-100 w-100 m-0" style="min-width: 100%;">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse sidebar-animation" style="background: #21D192; position: fixed;">
            <div class="position-sticky sidebar-sticky fixed">
                <div class="pt-5 mt-3 text-center">
                    <img src="../../images/logo-cnre.png" class="img-thumbnail" alt="photo" style="width: 80px;">
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-dark d-flex align-items-center link-animation" href="utilisateurs">
                            <?php include '../../icons/user-plus-svgrepo-com.svg' ?>
                            <span class="fs-6 fw-bold p-2">Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-white d-flex align-items-center link-animation" href="memoires">
                            <?php include '../../icons/book-svgrepo-com (1).svg' ?>
                            <span class="fs-6 fw-bold p-2">Mémoires</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-dark d-flex align-items-center link-animation" href="articles">
                            <?php include '../../icons/article-1-svgrepo-com.svg' ?>
                            <span class="fs-6 fw-bold p-2">Articles</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-white d-flex align-items-center link-animation" href="filieres">
                            <?php include '../../icons/field-svgrepo-com.svg' ?>
                            <span class="fs-6 fw-bold p-2">Filières</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <script src="../../js/animation.js"></script>
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 overflow-auto">