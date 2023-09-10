<?php

require_once 'include/db.inc.php';
require_once 'include/class_autoloader.inc.php';
require_once 'include/config.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'partials/__head.php'; ?>
    <title>Home page |
        <?= SITE_NAME ?>
    </title>
</head>

<body>
    <!-- Navigation -->
    <?php require_once 'partials/__nav.php'; ?>

    <!-- Page Header -->
    <?php require_once 'partials/__page_header.php'; ?>

    <!-- Main Content -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <?php

                try {
                    $blog = new Blog;
                    $user = new User;
                    $allPosts = $blog->getAllBlogPosts();

                    if (!empty($allPosts)) {
                        foreach ($allPosts['posts'] as $post) {

                            ?>
                            <div class="post-preview">
                                <a href="post.php?slug=<?= $post['slug'] ?>#disqus_thread">
                                    <h2 class="post-title">
                                        <?= $post['title']; ?>
                                    </h2>
                                    <h3 class="post-subtitle">
                                        <?php echo substr($post['excerpt'], 0, 150) ?>
                                    </h3>
                                </a>
                                <p class="post-meta">
                                    Posted by
                                    <a href="user.php?slug=<?= $user->getUserDetails($post['user_id'])[0]['slug'] ?>">
                                        <?php
                                        if (!empty($user->getUserDetails($post['user_id']))) {
                                            echo $user->getUserDetails($post['user_id'])[0]['name'];
                                        }
                                        ?>

                                    </a>
                                    on

                                    <?php
                                    $timeago = new get_timeago;
                                    echo $timeago->timeago($post['created_at']); ?>
                                </p>
                            </div>
                            <?php
                        }
                        if (count($allPosts) > 0) {
                            $pages = $blog->getAllBlogPosts()['pages'];
                            ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">

                                    <?php
                                    for ($i = 1; $i <= $pages; $i++) {
                                        $perPage = $blog->getAllBlogPosts()['per-page'];
                                        ?>
                                        <li class="page-item"> <a class="page-link"
                                                href="?page=<?php echo $i; ?>&&per-page=<?php echo $perPage ?>"><?= $i ?></a>
                                        </li>

                                        <?php

                                    }
                                    ?>
                                </ul>
                            </nav>
                            <?php
                        }
                    } else {
                        echo '<p>No posts available.</p>';
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>
                <!-- Pager -->
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a>
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