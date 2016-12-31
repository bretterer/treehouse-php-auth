<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';

requireAuth();

if(!isOwner())
?>



    <div class="container">
        <div class="well">
            <h2>My Account</h2>

            <div class="panel">
                <h4>Change Password</h4>
                <form class="form-signin" method="post" action="/procedures/changePassword.php">
                    <?php print display_errors(); ?>
                    <?php print display_success(); ?>
                    <input type="password" id="inputEmail" name="current_password" class="form-control" placeholder="Current Password" required autofocus>
                    <br>
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="New Password" required>
                    <br>
                    <input type="password" id="inputPassword" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Change Password</button>
                </form>
            </div>

        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>