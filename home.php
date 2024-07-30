<?php
session_start();

$path = '';

require_once 'php/functions.php';
login_required($path);

require 'php/partials/header.php';
?>

<main class="container mt-4 py-5">
    <h1>Bienvenue sur Notre application Web</h1>
    <p>C'est ici que vous pouvez voir et les télécharger des mémoire universitaire des étudiants!</p>

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class="active" aria-current="true"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item">
                <img src="images/book0.jpg" alt="image" srcset="" width="100%">
            </div>
            <div class="carousel-item active carousel-item-start">
                <img src="images/book1.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item carousel-item-next carousel-item-start">
                <img src="images/book2.jpg" class="d-block w-100" alt="Image 3">
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</main>

<script>
    $('.carousel').carousel({
        interval: 2000
    });
</script>

<?php require 'php/partials/footer.php'; ?>