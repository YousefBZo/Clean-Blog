<?php
ob_start();
// rest of your code
require_once 'include/recaptchalib.php';
require 'include/vendor/phpmailer/phpmailer/src/Exception.php';
require 'include/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'include/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';

class User extends DbConnect
{
    private $msg;

    public function __construct()
    {
        $this->msg = new \Plasticbrain\FlashMessages\FlashMessages();
    }

    private function isEmailFormEmpty($name, $email, $message, $subject)
    {
        return !empty($name) && !empty($email) && !empty($message) && !empty($subject);
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function sendMessage($name, $email, $message, $subject)
    {
        $secretkey = "6Ld2bdInAAAAAGnofbJUhlDeyWXD6yMKLfSNvxeU";
        $response = $_POST["g-recaptcha-response"];
        $verify = new recaptchalib($secretkey, $response);

        if ($verify->isValid() == false) {
            // What happens when the CAPTCHA was entered incorrectly
            $this->msg->error("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
            header('Refresh:5;url=contact.php');

        } else {
            if ($this->isEmailFormEmpty($name, $email, $message, $subject)) {
                if ($this->isValidEmail($email)) {
                    try {
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

                        $mail->Host = 'smtp.mailtrap.io';

                        $mail->SMTPAuth = true;
                        $mail->Username = '8fdc66b583cd8f'; // Update with your Gmail email
                        $mail->Password = 'f241bf14b69e61'; // Update with your Gmail app password
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                        //Recipients
                        $mail->setFrom($email, $name);
                        $mail->addAddress('zaqoutyousef@gmail.com', 'Yousef Zaqout'); //Add a recipient

                        //Content
                        $mail->isHTML(true); //Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        $mail->AltBody = $message;
                        // Sending the email
                        $mail->send();
                        $this->msg->success('Message has been sent');
                    } catch (Exception $e) {
                        $this->msg->error('Message could not be sent. Mailer Error');
                    }
                } else {
                    $this->msg->error('Please enter a valid email');
                }
            } else {
                $this->msg->error('Please fill in all fields');
            }
        }
    }

    private function checkIsRegisterFormEmpty($name, $email, $password, $password_confirmation)
    {
        return !empty($name) && !empty($email) && !empty($password) && !empty($password_confirmation);
    }

    private function checkIsEmailRegistered($email)
    {
        $sql = 'select email from users where email=?';
        $query = $this->connect()->prepare($sql);
        $query->execute([$email]);
        $emails = $query->fetchAll();
        if (count($emails) == 0) {
            return true;
        }
        return false;
    }

    private function checkIsPasswordsSame($password, $password_confirmation)
    {
        if ($password === $password_confirmation) {
            return true;
        }
        return false;
    }

    public function userRegistration($name, $email, $password, $password_confirmation)
    {
        $secretkey = "6Ld2bdInAAAAAGnofbJUhlDeyWXD6yMKLfSNvxeU";
        $response = $_POST["g-recaptcha-response"];
        $verify = new recaptchalib($secretkey, $response);

        if ($verify->isValid() == false) {
            // What happens when the CAPTCHA was entered incorrectly
            $this->msg->error("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
            header('Refresh:5;url=register.php');

        } else {
            if ($this->checkIsRegisterFormEmpty($name, $email, $password, $password_confirmation)) {
                if ($this->isValidEmail($email)) {
                    if ($this->checkIsEmailRegistered($email)) {
                        if ($this->checkIsPasswordsSame($password, $password_confirmation)) {
                            $ip_address = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['REMOTE_ADDR'];
                            $created_at = date('Y-m-d H:i:s');
                            $updated_at = date('Y-m-d H:i:s');
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $sql = 'insert into users(name,email,password,ip_address,created_at,updated_at)values(?,?,?,?,?,?)';
                            $query = $this->connect()->prepare($sql);
                            $query->execute([$name, $email, $hashed_password, $ip_address, $created_at, $updated_at]);
                            $this->msg->success('You are registered on our website.');
                        } else {
                            $this->msg->error('Your passwords are not the same');
                        }
                    } else {
                        $this->msg->error('Email address is already registered');
                    }
                } else {
                    $this->msg->error('Please enter a valid email');
                }
            } else {
                $this->msg->error('Please enter all fields');
            }
        }
    }
    private function checkIsLoginFormEmpty($email, $password)
    {
        return !empty($email) && !empty($password);
    }

    public function userLogin($email, $password)
    {

        $secretkey = "6Ld2bdInAAAAAGnofbJUhlDeyWXD6yMKLfSNvxeU";
        $response = $_POST["g-recaptcha-response"];
        $verify = new recaptchalib($secretkey, $response);

        if ($verify->isValid() == false) {
            // What happens when the CAPTCHA was entered incorrectly
            $this->msg->error("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
            header('Refresh:3;url=login.php');

        } else {
            if ($this->checkIsLoginFormEmpty($email, $password)) {
                if ($this->isValidEmail($email)) {
                    $sql = 'select * from users where email=? and active=? and banned=? ';
                    $query = $this->connect()->prepare($sql);
                    $query->execute([$email, 1, 0]);
                    $results = $query->fetchAll();
                    if (count($results) > 0) {
                        foreach ($results as $result) {
                            $hashed_password = $result['password'];
                            if (password_verify($password, $hashed_password)) {
                                $_SESSION['logged'] = 1;
                                $_SESSION['user_id'] = $result['id'];
                                $_SESSION['name'] = $result['name'];
                                $_SESSION['email'] = $result['email'];
                                $_SESSION['is_admin'] = $result['is_admin'];
                                $_SESSION['banned'] = $result['banned'];
                                $_SESSION['active'] = $result['active'];
                                $_SESSION['ip_address'] = $result['ip_address'];
                                $_SESSION['featured_image'] = $result['featured_image'];
                                header('Location:index.php');
                                exit();
                            } else {
                                $this->msg->error('Wrong email or password. Please try again');
                            }
                        }
                    } else {
                        $this->msg->error('There is no account with that email');
                    }
                } else {
                    $this->msg->error('Please enter a valid email');
                }
            } else {
                echo 'Please enter all fields';
            }
        }


    }

    public function passwordReset($email)
    {
        $secretkey = "6Ld2bdInAAAAAGnofbJUhlDeyWXD6yMKLfSNvxeU";
        $response = $_POST["g-recaptcha-response"];
        $verify = new recaptchalib($secretkey, $response);

        if ($verify->isValid() == false) {
            // What happens when the CAPTCHA was entered incorrectly
            $this->msg->error("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
            header('Refresh:5;url=password-reset.php');

        } else {
            if ($this->isValidEmail($email)) {
                $sql = 'select * from users where email=? and active=? and banned=? ';
                $query = $this->connect()->prepare($sql);
                $query->execute([$email, 1, 0]);
                $results = $query->fetchAll();
                if (count($results) > 0) {
                    $chars = 'qwertupioaghjagjxcvnadsfwfsaWERPIUAGHJKZVNASFDYUH';
                    $password = substr(str_shuffle($chars), 6, 10);
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = 'update users set password=? where email=?';
                    $query = $this->connect()->prepare($sql);
                    $query->execute([$hashed_password, $email]);
                    $this->msg->success('Your password has been reset and sent to your email');

                    try {
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

                        $mail->Host = 'smtp.mailtrap.io';

                        $mail->SMTPAuth = true;
                        $mail->Username = '8fdc66b583cd8f'; // Update with your Gmail email
                        $mail->Password = 'f241bf14b69e61'; // Update with your Gmail app password
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                        //Recipients
                        $mail->setFrom('zaqoutyousef@gmail.com', 'Zaqout');
                        $mail->addAddress($email); //Add a recipient

                        $subject = 'Password reset';
                        $message = 'Your new password is: ' . $password;

                        //Content
                        $mail->isHTML(true); //Set email format to HTML
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        $mail->AltBody = $message;
                        // Sending the email
                        $mail->send();
                        $this->msg->success('Message has been sent');
                    } catch (Exception $e) {
                        $this->msg->error('Message could not be sent. Mailer Error');
                    }
                } else {
                    $this->msg->error('No account found with this email');
                }
            } else {
                $this->msg->error('Invalid Email');
            }
        }
    }

    public function checkIsUserLoggedIn()
    {
        return isset($_SESSION['logged']);
    }
    public function userLogout()
    {
        if (isset($_SESSION['logged'])) {
            session_destroy();
            session_unset();
            header('Location:index.php');
        }
    }
    public function checkIsAdmin()
    {
        return $_SESSION['is_admin'] == 1;
    }
    public function getUserDetails($id)
    {

        $sql = 'select * from users where id=? limit 1 ';
        $query = $this->connect()->prepare($sql);
        $query->execute([$id]);
        $user = $query->fetchAll();

        return $user;
    }
    public function registeredUsers()
    {

        $sql = 'select * from users order by name asc ';
        $query = $this->connect()->query($sql);
        return $query->fetchAll();

    }
    private function checkIsUpdateUserFormEmpty($name, $email, $website_url, $about_me, $phone, $street, $city, $state, $postal_code)
    {

        if (!empty($name) && !empty($email) && !empty($website_url) && !empty($about_me) && !empty($phone) && !empty($street) && !empty($state) && !empty($postal_code)) {

            return true;
        } else {
            return false;
        }




    } // checkIsUpdateUserFormEmpty

    public function updateMyProfile($name, $email, $website_url, $about_me, $phone, $street, $city, $state, $postal_code)
    {

        if ($this->checkIsUpdateUserFormEmpty($name, $email, $website_url, $about_me, $phone, $street, $city, $state, $postal_code)) {

            if ($this->checkIsEmailRegistered($email)) {

                if ($this->isValidEmail($email)) {

                    $user_id = (int) $_SESSION['user_id'];
                    $sql = 'update users set name = :name , email = :email , website_url = :website_url , 
    about_me = :about_me , phone = :phone , street = :street , city = :city ,state = :state ,postal_code = :postal_code  where id = :id limit 1 ';

                    $query = $this->connect()->prepare($sql);
                    $query->bindValue(':name', $name);
                    $query->bindValue(':email', $email);
                    $query->bindValue(':website_url', $website_url);
                    $query->bindValue(':about_me', $about_me);
                    $query->bindValue(':phone', $phone);
                    $query->bindValue(':street', $street);
                    $query->bindValue(':city', $city);
                    $query->bindValue(':state', $state);
                    $query->bindValue(':postal_code', $postal_code);
                    $query->bindValue(':id', $user_id);

                    $query->execute();

                    header('Location:my-account.php');

                    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                    $msg->success('Your account is updated.');



                } else {
                    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                    $msg->error('Please , enter enter valid email address.');

                }
            } else {
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('Email address is already taken.');

            }
        } else {

            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Please , fill all fields in form.');

        }

    } // updateMyProfile
}
?>
<?php ob_end_flush() ?>