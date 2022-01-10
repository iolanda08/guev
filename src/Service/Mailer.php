<?php

namespace Service;

use Entity\Article;
use Entity\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public $mail;

    public function sendEmail(User $toUser)
    {
        $mail = new PHPMailer(true);
//Set PHPMailer to use SMTP.
        $mail->isSMTP();
//Set SMTP host name
        $mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
//Provide username and password
        $mail->Username = "guev323@gmail.com";
        $mail->Password = "Gemenigemeni1";
//If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "tls";
//Set TCP port to connect to
        $mail->Port = 587;

        $mail->From = "guev323@gmail.com";
        $mail->FromName = "GUEV GLOBAL APPLICATION";

        $mail->addAddress( $toUser->getEmail());

        $mail->isHTML(true);

        $mail->Subject = "Un nou utilizator a fost creat";
        $mail->Body = sprintf("<b>%s</b> a fost creat.", $toUser->getEmail());

        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }
    public function notifySubscribersByArticle(Article $article)
    {
        $userService = new ProcessUserService();

        $subscribers = $userService->getSubscribers();

        foreach ($subscribers as $subscriber) {
            $this->notifySubscriberByArticle($subscriber, $article);
        }

    }

    public function notifySubscriberByArticle(User $toUser, Article $article)
    {
        $mail = new PHPMailer(true);
//Set PHPMailer to use SMTP.
        $mail->isSMTP();
//Set SMTP host name
        $mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
//Provide username and password
        $mail->Username = "guev323@gmail.com";
        $mail->Password = "Gemenigemeni1";
//If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "tls";
//Set TCP port to connect to
        $mail->Port = 587;

        $mail->From = "guev323@gmail.com";
        $mail->FromName = "GUEV GLOBAL APPLICATION";

        $mail->addAddress( $toUser->getEmail());

        $mail->isHTML(true);

        $mail->Subject = "New article from subscription available";


        require "config.php";
        $mail->Body = sprintf("<p>
A aparut un nou articol in subcriptia dumneavoastra. Va rugam sa accesati linkul pentru a-l visiona.
<a href='$siteUrl/view_article.php?id={$article->getId()}'>{$article->getTitle()}</a>
</p>
");

        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }
    public function notifyUserNewToken(User $toUser)
    {
        $mail = new PHPMailer(true);
//Set PHPMailer to use SMTP.
        $mail->isSMTP();
//Set SMTP host name
        $mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
//Provide username and password
        $mail->Username = "guev323@gmail.com";
        $mail->Password = "Gemenigemeni1";
//If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "tls";
//Set TCP port to connect to
        $mail->Port = 587;

        $mail->From = "guev323@gmail.com";
        $mail->FromName = "GUEV GLOBAL APPLICATION";

        $mail->addAddress( $toUser->getEmail());

        $mail->isHTML(true);

        $mail->Subject = "Link resetare parola";


        require "config.php";
        $mail->Body = sprintf("<p>
Va rog sa accesati linkul de mai jos pentru a va reseta parola.
<a href='$siteUrl/autologin.php?token={$toUser->getToken()}'>Click aici pentru a va reseta parola.</a>
</p>
");

        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

}

