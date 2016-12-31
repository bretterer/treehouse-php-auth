<div class="media">
    <div class="media-left">
        <div class="btn-group-vertical" role="group">
            <a href="/procedures/vote.php?bookId=<?php echo $book['id']; ?>&vote=up">
                <span class="glyphicon glyphicon-triangle-top" <?php if($book['myVote'] == 1) : ?>style="color: orange;" <?php endif; ?> aria-hidden="true"></span>
            </a>
            <span><?php echo $book['score'] ? : '0'; ?></span>
            <a href="/procedures/vote.php?bookId=<?php echo $book['id']; ?>&vote=down">
                <span class="glyphicon glyphicon-triangle-bottom" <?php if($book['myVote'] == -1) : ?>style="color: orange;" <?php endif; ?> aria-hidden="true"></span>
            </a>
        </div>
    </div>

    <div class="media-body">
        <h4 class="media-heading"><?php echo $book['name']; ?></h4>
        <p><?php echo $book['description']; ?></p>
        <p>
            <?php if(isAdmin() || $book['owner_id'] == accessToken('sub')) : ?>
                <span><a href="/edit_book.php?bookId=<?php echo $book['id']; ?>">Edit</a> | </span>
                <span><a href="/procedures/deleteBook.php?bookId=<?php echo $book['id']; ?>">Delete</a></span>
            <?php endif; ?>
        </p>
    </div>

</div>