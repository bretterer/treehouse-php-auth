<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';
requireAuth();
    ?>



    <div class="container">
        <div class="well">

            <?php print display_errors(); ?>
            <?php print display_success(); ?>

            <h2>Add a book</h2>

            <form class="form-horizontal" method="post" action="/procedures/addBook.php">
                <?php include_once __DIR__ . '/_partials/bookForm.php'; ?>
            </form>

        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>