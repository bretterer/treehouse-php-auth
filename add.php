<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';
requireAuth();
    ?>



    <div class="container">
        <div class="well">
            <h2>Add a book</h2>

            <form class="form-horizontal" method="post" action="/procedures/addBook.php">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Book Title">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="5" placeholder="Description of the book"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Add Book</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>