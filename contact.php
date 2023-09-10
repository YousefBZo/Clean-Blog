<?php
require_once 'include/db.inc.php';
require_once 'include/class_autoloader.inc.php';
require_once 'include/config.inc.php';
require_once 'include/vendor/plasticbrain/php-flash-messages/src/FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'partials/__head.php'; ?>
    <style>
        .ck-editor__editable_inline {
            min-height: 251px;
        }
    </style>
    <title>Contact us|
        <?= SITE_NAME ?>
    </title>

</head>


<body>
    <!-- Navigation-->
    <?php require_once 'partials/__nav.php'; ?>
    <!-- Page Header-->
    <?php require_once 'partials/__page_header.php'; ?>

    <!-- Main Content-->

    <div class="container">

        <h3 class="text-center">Contact us</h3><br />

        <div class="row">
            <div class="col-md-8">
                <?php
                try {
                    if (isset($_POST['sendMessage'])) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $message = $_POST['message'];
                        $subject = $_POST['subject'];
                        $user = new User();
                        $user->sendMessage($name, $email, $message, $subject);

                    }
                } catch (PDOException $e) {
                    $e->getMessage();
                }

                $msg->display();

                ?>
                <form action="contact.php" method="post">
                    <input class="form-control" type="text" name="name" placeholder="Name..." /><br />
                    <input class="form-control" type="text" name="subject" placeholder="Subject..." /><br />
                    <input class="form-control" type="email" name="email" placeholder="E-mail..." /><br />
                    <textarea class="form-control" id="editor" name="message" placeholder="How can we help you?"
                        style="height:150px;"></textarea><br />


                    <div class="g-recaptcha" data-sitekey="6Ld2bdInAAAAAJnoZop8pUi3S2dne3ehh6nac0LJ">
                    </div>
                    <br>
                    <input class="btn btn-primary" type="submit" name="sendMessage" value="Send" /><br /><br />
                </form>
            </div>
            <div class="col-md-4">
                <b>Customer service:</b> <br />
                Phone: +1 129 209 291<br />
                E-mail: <a href="mailto:support@mysite.com">support@mysite.com</a><br />
                <br /><br />
                <b>Headquarter:</b><br />
                Company Inc, <br />
                Las vegas street 201<br />
                55001 Nevada, USA<br />
                Phone: +1 145 000 101<br />
                <a href="mailto:usa@mysite.com">usa@mysite.com</a><br />


                <br /><br />
                <b>Hong kong:</b><br />
                Company HK Litd, <br />
                25/F.168 Queen<br />
                Wan Chai District, Hong Kong<br />
                Phone: +852 129 209 291<br />
                <a href="mailto:hk@mysite.com">hk@mysite.com</a><br />


            </div>
        </div>

    </div>

    <!-- Footer-->
    <?php require_once 'partials/__footer.php'; ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>