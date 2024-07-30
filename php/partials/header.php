<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNRE</title>
    <link rel="stylesheet" href="<?php echo $path ?>icons/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $path ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $path ?>css/formulaire.css">
    <link rel="stylesheet" href="<?php echo $path ?>css/book.css">
    <link rel="stylesheet" href="<?php echo $path ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $path ?>css/article.css">

    <script src="<?php echo $path ?>js/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo $path ?>js/script.js"></script>
    <script src="<?php echo $path ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $path ?>js/popper.min.js"></script>
</head>

<body class='position-relative min-vh-100 w-100'>
    <?php require $path . "php/partials/search.php" ?>
    <div class="position-absolute w-100 min-vh-100" id="all">
        <header class='fixed-top w-100'>
            <nav class="navbar navbar-expand-lg px-2" style="background: #21D192;">
                <a class="navbar-brand text-white px-4" href="<?php echo $path ?>index">
                    <img src="<?php echo $path ?>images/mesupres" alt="" style="width: 55px; border-radius: 10%;">
                    <img src="<?php echo $path ?>images/logo-cnre.png" alt="" style="width: 37px; background-color: #fff; border-radius: 50%">
                    <span class="mt-2">CNRE</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav ml-auto align-items-md-center float-start ">

                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="<?php echo $path ?>home">
                                    <div style="max-width: 30px;">
                                        <?php include $path . "icons/home-1-svgrepo-com.svg"; ?>
                                    </div>
                                    <span class='p-2 text-white'>Accueil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="<?php echo $path ?>articles">
                                    <div style="max-width: 30px;">
                                        <?php include $path . "icons/article-1-svgrepo-com.svg"; ?>
                                    </div>
                                    <span class='p-2 text-white'>Articles</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="<?php echo $path ?>books">
                                    <div style="max-width: 30px;">
                                        <?php include $path . "icons/book-svgrepo-com (1).svg"; ?>
                                    </div>
                                    <span class='p-2 text-white'>Mémoires</span>
                                </a>
                            </li>
                            <li>
                                <button class="nav-link d-flex align-items-center me-4" onclick="afficher()">
                                    <div style="max-width: 30px;">
                                        <?php include $path . "icons/search.svg"; ?>
                                    </div>
                                    <span class='p-2 text-white'>Recherche</span>
                                </button>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown align-items-start" id="UserNavbarDropdown">

                        <?php if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_photo'])) : ?>
                            <button class="dropdown-toggle-split border-0 p-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                                <div style="max-width: 50px;">
                                    <?php include $path . "icons/user.svg"; ?>
                                </div>
                            </button>
                        <?php else : ?>
                            <button class="dropdown-toggle-split border-0 p-0 bg-transparent position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $path . $_SESSION['user_photo'] ?>" alt="" width="47px" height="47px" style="object-fit: cover; border-radius: 25px; border: 3px solid white">
                                <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle" style="width: 10px; height: 10px;"></div>
                            </button>
                        <?php endif; ?>

                            <div class="dropdown-menu" style="right: 0; left: auto;" aria-labelledby="UserNavbarDropdown">
                                <?php if (!isset($_SESSION['user_id'])) : ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>index">
                                        <div style="max-width: 30px;">
                                            <?php include $path . "icons/login.svg"; ?>
                                        </div>
                                        <span class="px-2">Connexion</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>php/inscription/inscription">
                                        <div style="max-width: 30px;">
                                            <?php include $path . "icons/login.svg"; ?>
                                        </div>
                                        <span class="px-2">Inscription</span>
                                    </a>
                                <?php else : ?>
                                    <a class="dropdown-item d-flex align-items-center" onclick="return confirm('Êtes-vous sûr de vouloir se déconnecté ?')" href="<?php echo $path ?>php/logout">
                                        <div style="width: 30px;">
                                            <?php include $path . "icons/logout.svg"; ?>
                                        </div>
                                        <span class="px-2">Deconnexion</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>profiles">
                                        <div style="width: 30px;">
                                            <?php include $path . "icons/user.svg"; ?>
                                        </div>
                                        <span class="px-2">Profils</span>
                                    </a>
                                    <?php if ($_SESSION['admin']): ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>php/admin/utilisateurs">
                                        <div style="max-width: 30px;">
                                            <?php include $path . "icons/setting.svg"; ?>
                                        </div>
                                        <span class="px-2">Administration</span>
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="position-relative container-fluid py-5 px-0">