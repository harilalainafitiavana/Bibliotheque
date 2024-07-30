<?php
require_once $path . 'php/functions.php';
login_required($path);

require $path . 'php/partials/header.php';
?>

<nav class="navbar navbar-expand-lg bg-light border-bottom mt-4">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <a style="background: #21D192;;" href="<?= $path . 'books' ?>" type="button" class="btn m-2">Tous</a>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-secondary">Année d'étude</button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= $path . 'php/recherche/recherche_par_annee.php' ?>?year=L3">L3</a></li>
                    <li><a class="dropdown-item" href="<?= $path . 'php/recherche/recherche_par_annee.php' ?>?year=M2">M2</a></li>
                    <li><a class="dropdown-item" href="<?= $path . 'php/recherche/recherche_par_annee.php' ?>?year=Doctorat">Doctorat</a></li>
                </ul>
            </div>

            <div class="btn-group me-2">
                <button type="button" class="btn btn-secondary">Filieres</button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <?php foreach ($filieres as $filiere) : ?>
                        <li>
                            <a href="<?= $path . 'php/recherche/recherche_par_filiere?name=' . $filiere['name'] ?>" class="dropdown-item"><?= htmlspecialchars($filiere['name']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 d-flex flex-wrap w-100 justify-content-evenly gap-3 my-4 mx-0">
        <?php if (!isset($livres) || empty($livres)) : ?>
            <h1 class="display-5 w-100 text-center mt-5 text-danger">
                Désolé, nous n'avons trouvé aucun livre.
            </h1>
        <?php else : ?>
            <?php foreach ($livres as $livre) : ?>
                <div class="livre">
                    <h5 style="text-align: center; margin-top: 50px;"><?php echo $livre['title']; ?></h5>
                    <div>
                        <p>
                            <?php echo $livre['universite']; ?>
                        </p>
                        <ul>
                            <li><strong style="color: rgb(11, 105, 228);">Auteur :</strong> <?php echo $livre['author']; ?></li>
                            <li><strong style="color: rgb(11, 105, 228);">Filiere :</strong> <?php echo $livre['filiere_name'] ; ?></li>
                        </ul>
                        <div style="display: flex;">
                            <a href="#" onclick="voirPlus(<?php echo $livre['id']; ?>)">Voir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div>
        <nav aria-label="Pagination links" class="justify-content-center d-flex">
            <ul class="pagination pagination-md flex-wrap">

                <li class="page-item">
                    <a class="page-link disabled" href="#">Previous</a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>

            </ul>
        </nav>
    </div>
    
</div>

<script>
function voirPlus(id) {
    // Construire l'URL avec l'identifiant du livre
    var url = 'description_memoire?id=' + id;
    // Rediriger l'utilisateur vers la page description.php
    window.location.href = url;
}
</script>


<?php require $path . 'php/partials/footer.php'; ?>