<?php
ob_start();
require_once '../include/db.inc.php';
require_once '../include/class_autoloader.inc.php';
require_once '../include/config.inc.php';
require_once '../include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

$admin = new Admin;
if (!$admin->checkIsAdmin()) {

    header('Location:../login.php');
    exit();
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
    <title>Blog categories |
        <?php echo SITE_NAME ?>
    </title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/chartsjs/Chart.min.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php require_once 'partials/__nav_sidebar.php'; ?>

        <div id="body" class="active">
            <?php require_once 'partials/__nav.php' ?>


            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Blog tags</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Blog tags</div>
                                <div class="card-body">
                                    <p class="card-title"></p>

                                    <?php
                                    try {

                                        $tags = new Admin;

                                        if (count($tags->getAllBlogTags()) > 0) {

                                            ?>
                                            <table class="table table-hover" id="dataTables-example" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th colspan="3">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    foreach ($tags->getAllBlogTags() as $tag) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $tag['id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $tag['name']; ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <a href="edit-tag.php?tag_id=<?php echo $tag['id']; ?>"
                                                                    class="btn btn-outline-info btn-rounded"><i
                                                                        class="fas fa-pen"></i></a>
                                                            </td>
                                                            <td>


                                                                <?php

                                                                if (isset($_POST['deleteBlogTag'])) {

                                                                    $admin = new Admin();
                                                                    $admin->deleteBlogTag($_GET['tag_id']);


                                                                } // main isset
                                                    


                                                                ?>
                                                                <form action="?tag_id=<?php echo $tag['id']; ?>" method="post">


                                                                    <button class="btn btn-outline-danger btn-rounded"
                                                                        name="deleteBlogTag" type="submit"><i
                                                                            class="fas fa-trash"></i></button>


                                                                </form>

                                                            </td>

                                                        </tr>
                                                        <?php
                                                    } // end foreach
                                    
                                        } else {
                                            echo 'There is no tags.';
                                        }






                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }

                                    $msg->display();

                                    ?>



                                        </tbody>
                                    </table>
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
<?php ob_end_flush(); ?>