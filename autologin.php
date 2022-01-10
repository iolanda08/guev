<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
session_start();

//$token=''; ??
$email = '';
$password = '';

$processUserService = new \Service\ProcessUserService();
if(empty($_GET['token'])) {

    $_SESSION['message']="Token not found";
    $_SESSION['msg_type']="warning";
    header("location:register.php");
    return;
}
$token = $_GET['token'];


    $user = $processUserService->getUserByToken($token);
    if(empty($user))
    {
        $_SESSION['message']="Invalid token";
        $_SESSION['msg_type']="warning";
        header("location:register.php");
        return;
    }

    $_SESSION['user_id'] = $user->getUserId();

    $processUserService->deleteToken($user);

$_SESSION['message']="Successfully logged in";
$_SESSION['msg_type']="success";
header("location:process_user.php?edit={$user->getUserId()}");



