<?php
ob_start();
require_once 'include/db.inc.php';
require_once 'include/class_autoloader.inc.php';
require_once 'include/config.inc.php';
$user = new User();
if (!$user->checkIsUserLoggedIn()) {
    header("Location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'partials/__head.php'; ?>
    <title>Registred users|
        <?= SITE_NAME ?>
    </title>
</head>

<body>
    <!-- Navigation -->
    <?php require_once 'partials/__nav.php'; ?>

    <!-- Page Header -->
    <?php require_once 'partials/__page_header.php'; ?>

    <!-- Main Content -->

    <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" colspan="3" style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $allUsers = $user->registeredUsers();
                    foreach ($allUsers as $user) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?= $user['id'] ?>
                            </th>
                            <td>
                                <?= $user['name'] ?>
                            </td>
                            <td>
                                <?= $user['email'] ?>
                            </td>
                            <td>
                                <?php
                                if ($_SESSION['user_id'] == $user['id']) {
                                    ?>
                                    <a href="my-account.php">My account</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="view-user.php?id=<?= $user['id'] ?>">View user profile</a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a href="messages.php?from_user=<?= $user['id'] ?>">Send message</a>
                            </td>
                            <td>
                                <a href="">Block user</a>
                            </td>
                        </tr>
                        <?php
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>


            </tbody>
        </table>

    </div>
    <!-- Footer -->
    <?php require_once 'partials/__footer.php'; ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>

</html>
<?php ob_end_flush(); ?>