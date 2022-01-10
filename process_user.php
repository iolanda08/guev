<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
session_start();

//$token=''; ??
$firstname = '';
$lastname = '';
$email = '';
$password = '';
$update = false;

$processUserService = new \Service\ProcessUserService();

if (!empty($_POST)) {
    if ($_SESSION['token'] != $_POST['token']) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
}

if (isset($_POST['login'])){
    if (empty($processUserService->loginUser())) {
        header('location:login.php');
    }
}


if (isset($_POST['forgotPassword'])){
    $email=$_POST['email'];
    $user=$processUserService->getUserByEmail($email);

    if(empty($user))
    {
        $_SESSION['message'] = "Wrong email address";
        $_SESSION['msg_type'] = "danger";
        header("location:forgotPassword.php");
        return;
    }

    $processUserService->resetUserPassword($user);

    $_SESSION['message'] = "Reset password link was sent on email";
    $_SESSION['msg_type'] = "success";
    header("location:index.php");
    header("location:index.php");
    return;
}

if (isset($_POST['save'])) {
    $newUser = $processUserService->saveUserFromPost();

    $mailer = new \Service\Mailer();
    $mailer->sendEmail($newUser);
    //$mailer->notifyAdminAbout($newUser);

    $_SESSION['user_id'] = $newUser->getUserId();
    header("location:index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $user = $processUserService->loadUser($id);
    $user->delete();

    $_SESSION['message'] = "Record has been deleted";
    $_SESSION['msg_type'] = "danger";

    header("location:index.php");
}
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;

    $user = $processUserService->loadUser($id);

    if ($user instanceof \Entity\User) {
        require_once "edit_user.php";
    }
}

if (isset($_POST['update'])) {
    $processUserService->updateUserFromPost();

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['msg_type'] = "warning";

    header('location:index.php');
}
