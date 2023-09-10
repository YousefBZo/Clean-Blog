<?php


require_once '../include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';


class Admin extends DbConnect
{
    private $msg;

    public function __construct()
    {
        $this->msg = new \Plasticbrain\FlashMessages\FlashMessages();
    }

    public function checkIsAdmin()
    {
        return $_SESSION['is_admin'] == 1;
    }

    public function getAllBlogCategories()
    {
        $sql = 'SELECT * FROM categories ORDER BY created_at DESC';
        $query = $this->connect()->query($sql);
        return $query->fetchAll();
    }

    public function getAllBlogTags()
    {
        $sql = 'SELECT * FROM tags ORDER BY created_at DESC';
        $query = $this->connect()->query($sql);
        return $query->fetchAll();
    }

    public function getAllRegisteredUsers()
    {
        $sql = 'SELECT * FROM users ORDER BY created_at DESC';
        $query = $this->connect()->query($sql);
        $users = $query->fetchAll();
        return $users;
    }

    public function getAllPosts()
    {
        $sql = 'SELECT * FROM posts ORDER BY created_at DESC';
        $query = $this->connect()->query($sql);
        $posts = $query->fetchAll();
        return $posts;
    }

    private function checkIsAllFieldsNotEmpty($name)
    {
        return !empty($name);
    }

    private function checkIsCategoryExist($name)
    {
        $sql = 'SELECT name FROM categories WHERE name = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$name]);
        if (count($query->fetchAll()) == 0) {
            return true;
        }
        return false;
    }

    private function checkIsTagExist($name)
    {
        $sql = 'SELECT name FROM tags WHERE name = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$name]);
        if (count($query->fetchAll()) == 0) {
            return true;
        }
        return false;
    }

    private function checkIsUserExist($name)
    {
        $sql = 'SELECT name FROM users WHERE name = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$name]);
        if (count($query->fetchAll()) == 0) {
            return false;
        }
        return true;
    }

    private function create_slug($string)
    {
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    }

    public function addCategory($name)
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        if ($this->checkIsAllFieldsNotEmpty($name)) {
            if ($this->checkIsCategoryExist($name)) {
                $slug = $this->create_slug($name);
                $sql = 'INSERT INTO categories (name, slug, created_at, updated_at) VALUES (?, ?, ?, ?)';
                $query = $this->connect()->prepare($sql);
                $query->execute([$name, $slug, $created_at, $updated_at]);
                $this->msg->success('Category is added.');
            } else {
                $this->msg->error('This category is in the database.');
            }
        } else {
            $this->msg->error('Please, fill all fields.');
        }
    }
    private function checkIsAllCategoryFieldsNotEmpty($name)
    {

        if (!empty($name)) {
            return true;
        } else {
            return false;
        }

    }

    public function editBlogCategory($name, $category_id)
    {

        if ($this->checkIsAllCategoryFieldsNotEmpty($name)) {


            if ($this->checkIsCategoryExist($name)) {

                $slug = $this->create_slug($name);




                $sql = 'update categories set name= ?  , slug = ? where id = ? limit 1 ';

                $query = $this->connect()->prepare($sql);
                $query->execute([$name, $slug, $category_id]);


                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->success('Category is changed.');

            } else {


                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('This category is in database.');
            } // checkIsCategoryExits



        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Please , fill all fields in form.');
        } // checkIsAllCategoryFieldsNotEmpty

    }

    public function editBlogTag($name, $tag_id)
    {

        if ($this->checkIsAllCategoryFieldsNotEmpty($name)) {


            if ($this->checkIsTagExist($name)) {

                $slug = $this->create_slug($name);




                $sql = 'update tags set name= ?  , slug = ? where id = ? limit 1 ';

                $query = $this->connect()->prepare($sql);
                $query->execute([$name, $slug, $tag_id]);


                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->success('tag is changed.');

            } else {


                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('This tag is in database.');
            } // checkIsCategoryExits



        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Please , fill all fields in form.');
        } // checkIsAllCategoryFieldsNotEmpty

    }

    public function addTag($name)
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        if ($this->checkIsAllFieldsNotEmpty($name)) {
            if ($this->checkIsTagExist($name)) {
                $slug = $this->create_slug($name);
                $sql = 'INSERT INTO tags (name, slug, created_at, updated_at) VALUES (?, ?, ?, ?)';
                $query = $this->connect()->prepare($sql);
                $query->execute([$name, $slug, $created_at, $updated_at]);
                $this->msg->success('Tag is added.');
            } else {
                $this->msg->error('This tag is in the database.');
            }
        } else {
            $this->msg->error('Please, fill all fields.');
        }
    }

    private function checkIsUsersFormEmpty(
        $name,
        $email,
        $password,
        $password_confirmation
    ) {
        if (!empty($name) && !empty($email) && !empty($password) && !empty($password_confirmation)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkIsEmailValid($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkIfPasswordsSame($password, $password_confirmation)
    {
        if ($password == $password_confirmation) {
            return true;
        } else {
            return false;
        }
    }

    private function checkIsEmailExistsInDb($email)
    {
        $sql = 'SELECT email FROM users WHERE email = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$email]);
        $results = $query->fetchAll();
        if (count($results) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser(
        $name,
        $email,
        $password,
        $password_confirmation,
        $active,
        $is_admin
    ) {
        if (
            $this->checkIsUsersFormEmpty(
                $name,
                $email,
                $password,
                $password_confirmation
            )
        ) {
            if ($this->checkIsEmailValid($email)) {
                if ($this->checkIfPasswordsSame($password, $password_confirmation)) {
                    if ($this->checkIsEmailExistsInDb($email)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $created_at = date('Y-m-d H:i:s');
                        $updated_at = date('Y-m-d H:i:s');
                        $slug = $this->create_slug($name);

                        $sql = 'INSERT INTO users (name, email, slug, password, active, is_admin, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
                        $query = $this->connect()->prepare($sql);
                        $query->execute([$name, $email, $slug, $hashed_password, $active, $is_admin, $created_at, $updated_at]);

                        $this->msg->success('User is added.');
                    } else {
                        $this->msg->error('This email is already registered.');
                    }
                } else {
                    $this->msg->error('Your passwords need to be the same.');
                }
            } else {
                $this->msg->error('Please enter a valid email address.');
            }
        } else {
            $this->msg->error('Please fill all fields in the form.');
        }
    }
    public function editUser(
        $name,
        $email,
        $password,
        $password_confirmation,
        $active,
        $is_admin,
        $user_id

    ) {
        if (
            $this->checkIsUsersFormEmpty(
                $name,
                $email,
                $password,
                $password_confirmation
            )
        ) {
            if ($this->checkIsEmailValid($email)) {
                if ($this->checkIfPasswordsSame($password, $password_confirmation)) {
                    if ($this->checkIsEmailExistsInDb($email)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $slug = $this->create_slug($name);

                        $sql = 'update users set name=?,email=?,slug=?,password=?,active=?,is_admin=? where id=?  ';
                        $query = $this->connect()->prepare($sql);
                        $query->execute([$name, $email, $slug, $hashed_password, $active, $is_admin, $user_id]);

                        $this->msg->success('User is edited.');
                    } else {
                        $this->msg->error('This email is already registered.');
                    }
                } else {
                    $this->msg->error('Your passwords need to be the same.');
                }
            } else {
                $this->msg->error('Please enter a valid email address.');
            }
        } else {
            $this->msg->error('Please fill all fields in the form.');
        }
    }

    private function checkIsPostFormEmpty(
        $title,
        $category_id,
        $tag_id,
        $featured_image,
        $excerpt,
        $content
    ) {
        if (!empty($title) && !empty($category_id) && !empty($tag_id) && !empty($featured_image) && !empty($excerpt) && !empty($content)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkIsTitleExitsInPosts($title)
    {
        $sql = 'SELECT title FROM posts WHERE title = ?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$title]);
        $titles = $query->fetchAll();
        if (count($titles) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addPost(
        $title,
        $category_id,
        $tag_id,
        $featured_image,
        $excerpt,
        $content,
        $featured
    ) {
        if (
            $this->checkIsPostFormEmpty(
                $title,
                $category_id,
                $tag_id,
                $featured_image,
                $excerpt,
                $content
            )
        ) {
            if ($this->checkIsTitleExitsInPosts($title)) {
                $created_at = date('Y-m-d H:i:s');
                $updated_at = date('Y-m-d H:i:s');
                $slug = $this->create_slug($title);
                $user_id = (int) $_SESSION['user_id'];

                $sql = 'INSERT INTO posts (title, slug, user_id, category_id, tag_id,  featured_image, excerpt,content, views,featured, soft_deleted, created_at, updated_at ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                $query = $this->connect()->prepare($sql);
                $query->execute([$title, $slug, $user_id, $category_id, $tag_id, $featured_image, $excerpt, $content, 0, $featured, 0, $created_at, $updated_at]);

                $this->msg->success('Post is added to the database.');
            } else {
                $this->msg->error('Please change your title.');
            }
        } else {
            $this->msg->error('Please fill all fields in the form.');
        }
    }
    public function deleteBlogCategory($category_id)
    {

        $sql = 'delete from categories where id = :category_id limit 1 ';

        $query = $this->connect()->prepare($sql);

        $query->bindValue(':category_id', $category_id);

        $query->execute();
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success('Category deleted.');

        header('Location:categories.php');


    } // deleteBlogCategory
    public function deleteBlogTag($tag_id)
    {
        $sql = 'delete from tags where id = :tag_id limit 1 ';

        $query = $this->connect()->prepare($sql);

        $query->bindValue(':tag_id', $tag_id);

        $query->execute();
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success('Tag deleted.');

        header('Location:tags.php');
    }
    public function deleteBlogPost($post_id)
    {
        $sql = 'delete from posts where id = :post_id limit 1 ';

        $query = $this->connect()->prepare($sql);

        $query->bindValue(':post_id', $post_id);

        $query->execute();
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success('Posts deleted.');

        header('Location:posts.php');
    }
    public function deleteUserAccount($user_id)
    {
        $sql = 'delete from users where id = :user_id limit 1 ';

        $query = $this->connect()->prepare($sql);

        $query->bindValue(':user_id', $user_id);

        $query->execute();
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->success('User deleted.');

        header('Location:users.php');
    }
    public function editPost(
        $title,
        $category_id,
        $tag_id,
        $featured_image,
        $excerpt,
        $content,
        $featured,
        $post_id

    ) {
        if (
            $this->checkIsPostFormEmpty(
                $title,
                $category_id,
                $tag_id,
                $featured_image,
                $excerpt,
                $content
            )
        ) {
            if ($this->checkIsTitleExitsInPosts($title)) {

                $slug = $this->create_slug($title);
                $user_id = (int) $_SESSION['user_id'];

                $sql = 'update posts set title=?,slug=?,user_id=?,category_id=?,tag_id=?,featured_image=?,excerpt=?,content=?,featured=? where id=?  ';
                $query = $this->connect()->prepare($sql);
                $query->execute([$title, $slug, $user_id, $category_id, $tag_id, $featured_image, $excerpt, $content, $featured, $post_id]);

                $this->msg->success('Post is edited to the database.');
            } else {
                $this->msg->error('Please change your title.');
            }
        } else {
            $this->msg->error('Please fill all fields in the form.');
        }
    }
}
?>