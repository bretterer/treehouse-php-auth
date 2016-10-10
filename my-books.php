<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';

requireAuth();

?>


    <div class="container">
        <div class="well">
            <h2>Book List</h2>
            <?php
            if($session->getFlashBag()->has('flash')) :
                $message = $session->getFlashBag()->get('flash')[0];
                ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message; ?>
                </div>
                <?php

            endif;
            ?>
            <?php foreach( getMyBooks() as $book ) : ?>
                <?php include __DIR__ . '/_partials/book.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>