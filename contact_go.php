<?php
include_once 'header.php';

$sent = false;

require ('assets/recaptcha/autoload.php');
include_once('assets/recaptcha/secret.php'); //produces $secret

$recaptcha = new \ReCaptcha\ReCaptcha($secret);

$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
if (!$resp->isSuccess()) {
    $errors = $resp->getErrorCodes();
    die('Captcha not verified!');
}



//Remove special characters from $name if they get through the
//jquery check somehow, make sure $email is valid, and
//$message's str_replace recommended as per PHP docs
$name = preg_replace('/[^A-Za-z0-9\ ]/', '', $_POST['contactName']);
$email = filter_var($_POST['contactEmail'], FILTER_VALIDATE_EMAIL);
$message = str_replace("\n.", "\n..", $_POST['contactMessage']);


$to = "mulatti@uwindsor.ca";
$subject = "Resume Critic Contact Form";
$headers = "From: $name <$email>\r\nReply-To: $email";

if ($email != false){
    if (mail ($to, $subject, $message, $headers))
        $sent = true;
    else
        $sent = false;
    }
?>

<!-- Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">


        <?php if ($sent): ?>
            <!-- Page Heading -->
            <div class="text-center">
                <h1>Thank you!</h1>
            </div>
            <hr>

            <p class="lead text-center">
                Thanks for your feedback! Your message has been sent, and you
                should hear back from us shortly.
            </p>

        <?php else: ?>
            <!-- Page Heading -->
            <div class="text-center">
                <h1>Oh no!</h1>
            </div>
            <hr>

            <p class="lead text-center">
                We couldn't send your message. Please try again, or email one
                of the admins directly.
            </p>
        <?php endif; ?>

        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->






<?php include_once 'footer.php'; ?>
