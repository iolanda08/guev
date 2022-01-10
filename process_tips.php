<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$firstname = '';
$lastname = '';
$talent = '';
$fblink = '';
$instalink = '';
$phone = '';

$processTipService = new \Service\ProcessTipService();

if (isset($_POST['sendTip'])) {
    $newTip = $processTipService->saveTipFromPost();
    $_SESSION['message'] = "Tip has been sent";
    $_SESSION['msg_type'] = "success";
    header('location:index.php');

}