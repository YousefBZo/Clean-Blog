<?php
class Blog extends DbConnect
{
    public function getAllBlogPosts()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 5 ? (int) $_GET['per-page'] : 5;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $sql = 'SELECT * FROM posts ORDER BY created_at DESC Limit :start,:perPage';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $query->execute();
        $posts = $query->fetchAll();

        $sql = 'SELECT * FROM posts ORDER BY created_at DESC  ';
        $query = $this->connect()->query($sql);
        $postsCount = $query->fetchAll();
        $allPosts = Count($postsCount);
        $pages = ceil($allPosts / $perPage);
        return array('pages' => $pages, 'posts' => $posts, 'per-page' => $perPage);
    }
    public function getPostContent($slug)
    {
        $sql = 'SELECT * FROM posts where slug=?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$slug]);
        $post = $query->fetch();
        if (!$post) {
            header("Location:index.php");
            exit();
        }
        return $post;
    }
    public function getCategoryDetails($id)
    {

        $sql = 'SELECT * FROM categories where id=?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$id]);
        return $query->fetch();
    }
    public function getTagDetails($id)
    {

        $sql = 'SELECT * FROM tags where id=?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$id]);
        $tag = $query->fetch();
        return $tag;
    }
    public function getAllCategories()
    {
        $sql = 'SELECT * FROM categories order by name asc';
        $query = $this->connect()->query($sql);
        $query->execute();
        $cat = $query->fetchAll();
        return $cat;

    }
    public function getAllCategoryPosts($category_id)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 5 ? (int) $_GET['per-page'] : 5;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $sql = 'SELECT * FROM posts where category_id=:category_id ORDER BY  created_at DESC Limit :start,:perPage';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $query->execute();
        $posts = $query->fetchAll();

        $sql = 'SELECT * FROM posts where category_id =?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$category_id]);
        $postsCount = $query->fetchAll();
        $allPosts = Count($postsCount);
        $pages = ceil($allPosts / $perPage);
        return array('pages' => $pages, 'posts' => $posts, 'per-page' => $perPage);

    }
    public function checkISPostFavouritePosts($post_id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = 'SELECT * FROM favourite_posts where post_id =? and user_id=?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$post_id, $user_id]);
        $results = $query->fetchAll();
        return Count($results) > 0;

    }
    public function addToFavouritePosts($post_id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = 'insert into favourite_posts (post_id,user_id)values(?,?)';
        $query = $this->connect()->prepare($sql);
        $query->execute([$post_id, $user_id]);
        echo 'Added Successful';
        header("Location:" . $_SERVER['HTTP_REFERER']);
        exit();
    }
    public function removeFromFavouritePosts($post_id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = 'DELETE FROM favourite_posts WHERE post_id = ? AND user_id = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$post_id, $user_id]);
        echo 'Deleted Successful';
        header("Location:" . $_SERVER['HTTP_REFERER']);
        exit();
    }
    public function getAllFavouriteBlogPosts()
    {
        $user_id = $_SESSION['user_id'];
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 5 ? (int) $_GET['per-page'] : 5;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $sql = 'SELECT * FROM posts p left join favourite_posts f on p.id=f.post_id  where f.user_id=:user_id ORDER BY created_at DESC Limit :start,:perPage';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $query->execute();
        $posts = $query->fetchAll();
        $sql = 'SELECT * FROM posts p left join favourite_posts f on p.id=f.post_id  where f.user_id=? ';
        $query = $this->connect()->prepare($sql);
        $query->execute([$user_id]);
        $postsCount = $query->fetchAll();
        $allPosts = Count($postsCount);
        $pages = ceil($allPosts / $perPage);

        return array('pages' => $pages, 'posts' => $posts, 'per-page' => $perPage);
    }
    public function searchBlog($keyword)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 5 ? (int) $_GET['per-page'] : 5;
        $start = ($page > 1) ? ($page - 1) * $perPage : 0;

        $sql = 'SELECT * FROM posts WHERE title LIKE :keyword ORDER BY created_at DESC LIMIT :start, :perPage';
        $query = $this->connect()->prepare($sql);
        $query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $query->bindValue(':start', $start, PDO::PARAM_INT);
        $query->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $query->execute();
        $posts = $query->fetchAll();

        $countSql = 'SELECT COUNT(*) FROM posts WHERE title LIKE :keyword';
        $countQuery = $this->connect()->prepare($countSql);
        $countQuery->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $countQuery->execute();
        $allPosts = $countQuery->fetchColumn();
        $pages = ceil($allPosts / $perPage);

        return [
            'pages' => $pages,
            'posts' => $posts,
            'per-page' => $perPage,
        ];
    }

    public function getAllTagPosts($tag_id)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 5 ? (int) $_GET['per-page'] : 5;
        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
        $sql = 'SELECT * FROM posts where tag_id=:tag_id ORDER BY  created_at DESC Limit :start,:perPage';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $query->bindParam(':start', $start, PDO::PARAM_INT);
        $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $query->execute();
        $posts = $query->fetchAll();

        $sql = 'SELECT * FROM posts where tag_id =?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$tag_id]);
        $postsCount = $query->fetchAll();
        $allPosts = Count($postsCount);
        $pages = ceil($allPosts / $perPage);
        return array('pages' => $pages, 'posts' => $posts, 'per-page' => $perPage);

    }
}