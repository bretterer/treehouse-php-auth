
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Book Voting</a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <?php if(isAdmin()): ?>
                <li><a href="/admin.php">Admin</a></li>
                <?php endif; ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if(!isAuthenticated()) : ?>
                <li><a href="/login.php">Login</a></li>
                <li><a href="/register.php">Register</a></li>
                <?php else : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo user('email'); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/add.php">Submit Book</a></li>
                        <li><a href="/my-books.php">My Books</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/account.php">My Account</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>