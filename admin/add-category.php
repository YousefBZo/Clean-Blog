<?php
require_once '../include/db.inc.php';
require_once '../include/class_autoloader.inc.php';
require_once '../include/config.inc.php';
require_once '../include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
$admin = new Admin();
if (!$admin->checkIsAdmin()) {
    header('Location:../login.php');
}
?>
<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add blog category|
        <?= SITE_NAME ?>
    </title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php require_once 'partials/__nav_sidebar.php'; ?>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <?php require_once 'partials/__nav.php'; ?>

            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Add category</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">Add category</div>
                                <div class="card-body">
                                    <?Php
                                    try {
                                        if (isset($_POST['addCategory'])) {
                                            $name = htmlspecialchars(trim($_POST['name']));
                                            $admin->addCategory($name);
                                        }
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    $msg->display();
                                    ?>
                                    <form accept-charset="utf-8" method="post" action="add-category.php">
                                        <div class="mb-3 row">
                                            <label class="col-sm-2 form-label" for="name">Category name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" placeholder="Category name"
                                                    class="form-control">
                                                <small class="form-text">Example help text that remains
                                                    unchanged.</small>
                                            </div>
                                        </div>

                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <input type="submit" name="addCategory" class="btn btn-primary">
                                    </div>
                                </div>
                                </form>
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
</body>

</html>