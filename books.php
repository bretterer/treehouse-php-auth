<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';

?>



    <div class="container">
        <div class="well">
            <?php print display_errors(); ?>
            <?php print display_success('success'); ?>
            <?php print display_success('flash'); ?>
            <h2>Book List</h2>

            <?php foreach( getAllBooks() as $book ) : ?>
                <?php include __DIR__ . '/_partials/book.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>