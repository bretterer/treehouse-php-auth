<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';
requireAuth();

$book = getBook(request()->get('bookId'));

if(empty($book)) {
    $session->getFlashBag()->add('error', 'Book Not Found!');
    redirect('/books.php');
}

if(!isAdmin() && $book['owner_id'] != accessToken('sub')) {
    redirect('/unauthorized.php');
}
$bookTitle = $book['name'];
$bookDescription = $book['description'];
$buttonText = 'Update Book';
?>



    <div class="container">
        <div class="well">
            <h2>Add a book</h2>

            <form class="form-horizontal" method="post" action="/procedures/editBook.php">
                <input type="hidden" name="bookId" value="<?php print $book['id']; ?>" />
                <?php include_once __DIR__ . '/_partials/bookForm.php'; ?>
            </form>

        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>