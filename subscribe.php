<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php require_once __DIR__ . '/vendor/autoload.php'; ?>
<?php
require "session.php";
if ($currentUser->isAnounymous()) {

    $_SESSION['message'] = "Please log in first";
    $_SESSION['msg_type'] = "danger";
    header("location:login.php");
    return;

}
$userService = new \Service\ProcessUserService();

$currentUser->subscribe();


$_SESSION['message'] = "Successfully subscribed to newsletter!";
$_SESSION['msg_type'] = "success";
header("location:index.php");