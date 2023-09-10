<?php

require_once 'include/db.inc.php';
require_once 'include/class_autoloader.inc.php';
require_once 'include/config.inc.php';
$user = new User();
if (!$user->checkIsUserLoggedIn()) {

    header('Location:login.php');
    exit();
}
$user_id = (int) $_GET['id'];
if (!$user_id) {
    header('Location:users.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'partials/__head.php'; ?>
    <style>
        .account-settings .user-profile {
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            text-align: center;
        }

        .account-settings .user-profile .user-avatar {
            margin: 0 0 1rem 0;
        }

        .account-settings .user-profile .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .account-settings .user-profile h5.user-name {
            margin: 0 0 0.5rem 0;
        }

        .account-settings .user-profile h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .account-settings .about {
            margin: 2rem 0 0 0;
            text-align: center;
        }

        .account-settings .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }

        .account-settings .about p {
            font-size: 0.825rem;
        }

        .form-control {
            border: 1px solid #cfd1d8;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }
    </style>
    <title>View user prifile |
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
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                </div>
                                <h5 class="user-name">
                                    <?= $user->getUserDetails($user_id)[0]['name'] ?>
                                </h5>
                                <h6 class="user-email">
                                    <?= $user->getUserDetails($user_id)[0]['email'] ?>
                                </h6>
                            </div>
                            <div class="about">
                                <h5>View user prifile</h5>
                                <p>
                                    <?= $user->getUserDetails($user_id)[0]['about_me'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Personal Details</h6>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name='name' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['name'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input type="email" class="form-control" id="eMail" name='email' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['email'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name='phone' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['phone'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Website URL</label>
                                    <input type="url" class="form-control" id="website" name='website_url' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['website_url'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="zIp">About me</label>
                                    <textarea name="about_me" id="" cols="50" class='form-control' disabled
                                        rows="5"><?= $user->getUserDetails($user_id)[0]['about_me'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street">Street</label>
                                    <input type="name" class="form-control" id="Street" name='street' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['street'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">City</label>
                                    <input type="name" class="form-control" id="ciTy" name='city' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['city'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">State</label>
                                    <input type="text" class="form-control" id="sTate" name='state' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['state'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Zip Code</label>
                                    <input type="text" class="form-control" id="zIp" name='postal_code' disabled
                                        placeholder="<?= $user->getUserDetails($user_id)[0]['postal_code'] ?>">
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <a href="messages.php?from_user=<?= $user->getUserDetails($user_id)[0]['id'] ?>"
                                        class="btn btn-primary" role="button">Send message</a>
                                    <a href="" class="btn btn-danger" role="button">Block
                                        user</a>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php require_once 'partials/__footer.php'; ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>

</html>