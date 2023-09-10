<?PHP ob_start();
?>
<!-- Include Bootstrap CSS -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <?php echo SITE_NAME; ?>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php
                $logged = new User();
                if ($logged->checkIsUserLoggedIn()) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" aria-haspopup="true"
                            aria-expanded="false">
                            Welcome back, <?php echo $_SESSION['name'] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="dropdownMenu">
                            <a class="dropdown-item" href="my-account.php">My account</a>
                            <a class="dropdown-item" href="favourite-blog-posts.php">Favourite blog posts</a>
                            <a class="dropdown-item" href="messages.php">Messages</a>
                             <?PHP
                            $admin = new User;

                            if ($admin->checkIsAdmin()) {
                                ?>
                                <a class="dropdown-item" href="admin/dashboard.php">Admin dashboard</a>
                            <?php } ?>
                            <a class="dropdown-item" href="users.php">Registered users</a>
                            <?php
                            $admin = new User;
                            if (isset($_POST['userLogout'])) {

                                $userLogout = new User;
                                $userLogout->userLogout();


                            }
                            ?>

                            <div class="dropdown-divider"></div>
                            <form action="" method="post">
                                <button name="userLogout" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <?php
                }
                ?>

                <li class="nav-item">
                    <form action="search.php" method="get" class="form-inline">
                        <input type="text" class="form-control form-control-sm" name="keyword" placeholder="Search">
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Include jQuery (before Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Your Custom JavaScript -->
<script>
    $(document).ready(function () {
        const dropdownToggle = document.getElementById('dropdownMenuLink');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownToggle.addEventListener('click', function (event) {
            event.preventDefault();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
</script>