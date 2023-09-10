<?php
ob_start();
require_once '../include/db.inc.php';
require_once '../include/class_autoloader.inc.php';
require_once '../include/config.inc.php';
require_once '../include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
$admin = new Admin;
if (!$admin->checkIsAdmin()) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog posts |
        <?php echo SITE_NAME; ?>
    </title>
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/vendor/chartsjs/Chart.min.css">
    <link rel="stylesheet" href="assets/vendor/flagiconcss/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css">
</head>

<body>
    <div class="wrapper">
        <?php require_once 'partials/__nav_sidebar.php'; ?>
        <div id="body" class="active">
            <?php require_once 'partials/__nav.php'; ?>
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Blog posts</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Blog posts</div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <?php
                                    try {
                                        $posts = new Admin;
                                        $allPosts = $posts->getAllPosts();
                                        if (count($allPosts) > 0) {
                                            ?>
                                            <table class="table table-hover" id="example" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Slug</th>
                                                        <th>Views</th>
                                                        <th>Created at</th>
                                                        <th>Featured</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($allPosts as $post) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $post['title']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $post['slug']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $post['views']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $post['created_at']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ($post['featured'] == 1) ? 'Featured' : 'Not featured'; ?>
                                                            </td>

                                                            <td class="text-right">
                                                                <a href="edit-post.php?post_id=<?php echo $post['id']; ?>"
                                                                    class="btn btn-outline-info btn-rounded">
                                                                    <i class="fas fa-pen"></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (isset($_POST['deletePost'])) {
                                                                    $posts->deleteBlogPost($_GET['post_id']);
                                                                }
                                                                ?>
                                                                <form action="?post_id=<?= $post['id'] ?>" method="post">

                                                                    <button class="btn btn-outline-danger btn-rounded"
                                                                        name="deletePost" type="submit">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        } else {
                                            echo 'There are no posts.';
                                        }
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    $msg->display();

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="assets/js/dashboard-charts.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>

</html>
<?php ob_end_flush(); ?>