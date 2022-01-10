<!DOCTYPE html>
<html lang="en-uk">
<head>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php require_once __DIR__ . '/vendor/autoload.php'; ?>
<?php require_once 'process_user.php'; ?>
<?php require_once 'msg.php'; ?>

<!--//@todo access denied pentru useri-->
<?php
$userService = new \Service\ProcessUserService();
$users = $userService->getAllUsers();

$_SESSION['token'] = bin2hex(random_bytes(32));

?>
<div class="form-body">
    <div class="container">

        <div class="row">
            <div class="form-content">

                <h3 style="margin-top: 30px;">Log in</h3>
                <p><a href="forgotPassword.php">Forgot password?</a></p>
            </div>
        </div>
        <div class="row">
            <div class="form-content">
                <div class="form-items">

                    <form action="process_user.php" method="POST">

                        <div class="form-group">
                            <label>E-mail </label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo !empty($_POST['email']) ? $_POST['email'] : null; ?>"
                                   placeholder="Enter your e-mail">
                        </div>

                        <div class="form-group">
                            <label>Password </label>
                            <input type="password" name="password" class="form-control"
                                   value="" placeholder="Enter your password">
                        </div>


                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">

                        <div class="form-group">
                                <button type="submit" class=" btn btn-primary" name="login">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

