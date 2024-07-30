<section class="d-none rounded-4" id="search">
    <div class="border-bottom-0 w-100">
        <h1 class="fs-5 fw-bold d-flex justify-content-between">
            <span>Rechercher un mémoire </span>
            <button class="bg-transparent" style="outline: none; border: none;" onclick="afficher()">
                <div style="width: 30px;">
                    <?php include $path . "icons/close.svg"; ?>
                </div>
            </button>
        </h1>
    </div>
    <div class="w-100">
        <form class="w-100 d-flex justify-content-between rounded-3 border text-bg-secondary border-1 border-secondary" role="search" action="<?= $path . 'php/recherche/recherche'; ?>" method="get">
            <input type="text" name="query" autofocus required class="me-2 px-3 bg-transparent text-white" placeholder="search...." style="outline: none; border: none;">
            <button type="submit" class="btn p-0">
                <div style="width: 50px;">
                    <?php include $path . "icons/search2.svg"; ?>
                </div>
            </button>
        </form>
    </div>
</section>