<?php
ob_start();
require_once 'include/db.inc.php';
require_once 'include/class_autoloader.inc.php';
require_once 'include/config.inc.php';
require_once 'include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if (!isset($_GET['slug'])) {
    header('Location:index.php');
    exit();
}
$blog = new Blog();
$slug = $_GET['slug'];
$user = new User();
$category_id = $blog->getPostContent($slug)['category_id'];
$tag_id = $blog->getPostContent($slug)['tag_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'partials/__head.php'; ?>
    <title>
        <?= $blog->getPostContent($slug)['title']; ?> |
        <?= SITE_NAME ?>
    </title>
</head>

<body>
    <!-- Navigation -->
    <?php require_once 'partials/__nav.php'; ?>



    <!-- Main Content -->
    <!-- Page Header-->
    <header class="masthead" style="background-image: url('assets/img/post-bg.jpg')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1>
                            <?= $blog->getPostContent($slug)['title']; ?>
                        </h1>
                        <h2 class="subheading">
                            <?= substr($blog->getPostContent($slug)['excerpt'], 0, 150); ?>
                        </h2>
                        <span class="meta">
                            Posted by
                            <a
                                href="user.php?slug=<?= $user->getUserDetails($blog->getPostContent($slug)['user_id'])[0]['slug']; ?>">

                                <?= ($user->getUserDetails($blog->getPostContent($slug)['user_id'])[0]['name']); ?>
                            </a>
                            on
                            <?php
                            $timeago = new get_timeago;

                            echo $timeago->timeago($blog->getPostContent($slug)['created_at']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Post Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <?= $blog->getPostContent($slug)['content'] ?>
                    <p>
                        Category :
                        <a href="categroy.php?slug=<?= $blog->getCategoryDetails($category_id)['slug'] ?>">
                            <?= $blog->getCategoryDetails($category_id)['name'] ?>
                        </a>
                    </p>
                    <p>
                        Tag :
                        <a href="tag.php?slug=<?= $blog->getTagDetails($tag_id)['slug'] ?>">
                            <?php print_r($blog->getTagDetails($tag_id)['name']) ?>
                        </a>
                    </p>
                    <br>
                    <?php
                    $user = new User();
                    if ($user->checkIsUserLoggedIn()) {
                        $favourites = new Blog;
                        $post_id = $blog->getPostContent($slug)['id'];

                        ?>
                        <form action="" method="post">
                            <?php
                            if (!$favourites->checkISPostFavouritePosts($post_id)) {
                                if (isset($_POST['addToFavouritePosts'])) {
                                    $favourites->addToFavouritePosts($post_id);
                                }
                                ?>
                                <button name="addToFavouritePosts" type="submit" class="btn btn-primary">
                                    Add to favourite posts</button>
                                <?php
                            } else {

                                if (isset($_POST['removeFromFavouritePosts'])) {
                                    $favourites->removeFromFavouritePosts($post_id);
                                }
                                ?>
                                <button name="removeFromFavouritePosts" type="submit" class="btn btn-primary">
                                    Remove from favourite posts</button>
                                <?php
                            } ?>

                        </form>
                        <?php
                    } else {
                        echo 'You must be login';
                    }
                    ?>

                    <br>
                    <div id="disqus_thread"></div>
                    <script>
                        /**
                        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                        /*
                        var disqus_config = function () {
                        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                        };
                        */
                        (function () { // DON'T EDIT BELOW THIS LINE
                            var d = document, s = d.createElement('script');
                            s.src = 'https://clean-blog-5.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments
                            powered by Disqus.</a></noscript>
                    <br>
                </div>
            </div>
        </div>
    </article>

    <!-- Footer -->
    <?php require_once 'partials/__footer.php'; ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
    <script id="dsq-count-scr" src="//clean-blog-5.disqus.com/count.js" async></script>
</body>

</html>
<?PHP ob_end_flush(); ?>