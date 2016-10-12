<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/_partials/head.php';
require_once __DIR__ . '/_partials/nav.php';

requireAdmin();

$users = getAllUsers();

?>



    <div class="container">
        <div class="well">

            <?php print display_errors(); ?>
            <?php print display_success(); ?>
            <h2>Admin</h2>

            <div class="panel">
                <h4>Users</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Registered</th>
                            <th>Promote/Demote</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user) : ?>
                        <tr>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['created_at']; ?></td>
                            <td>
                                <?php if($user['id'] != accessToken('sub')) : ?>
                                    <?php if($user['role_id'] == 2): ?>
                                    <a href="/procedures/adjustRole.php?role=promote&userId=<?php echo $user['id']; ?>" class="btn btn-xs btn-success">Promote to Admin</a>
                                    <?php elseif($user['role_id'] == 1): ?>
                                    <a href="/procedures/adjustRole.php?role=demote&userId=<?php echo $user['id']; ?>" class="btn btn-xs btn-warning">Demote from Admin</a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <a class="btn btn-xs btn-default">Cannot alter your role</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

<?php require_once __DIR__ . '/_partials/footer.php'; ?>