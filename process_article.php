<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
require "session.php";

if ($currentUser->isAnounymous()) {
    $_SESSION['msg_type'] = 'danger';
    $_SESSION['message'] = 'Please log in first';
    header('location:index.php');
    return;
}

$articleService = new \Service\ProcessArticleService();
$article = $articleService->getCurrentArticle();

if (isset($_POST['save'])) {
    $newArticle = $articleService->saveArticleFromPost();


    $mailer = new \Service\Mailer();

    $mailer->notifySubscribersByArticle($newArticle);

    header("location:view_article.php?id={$newArticle->getId()}");
}

if (isset($_POST['update'])) {
    $article = $articleService->updateArticleFromPost();

    $_SESSION['msg_type'] = 'success';
    $_SESSION['message'] = 'Successfully updated the article';
    header("location:view_article.php?id={$article->getId()}");
}

?>

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
    <title>Register</title>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body>


<header>
    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">About</h4>
                    <p class="text-muted">Add info</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Follow on Twitter</a></li>
                        <li><a href="#" class="text-white">Like on Facebook</a></li>
                        <li><a href="#" class="text-white">Email me</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2"
                     viewBox="0 0 24 24">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <strong>GUEV</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>

<div class="form-body">
    <div class="container">

        <div class="row">
        </div>
        <div class="row">
            <div class="form-content">
                <div class="form-items">

                    <form enctype="multipart/form-data" action="<?= empty($article) ? 'process_article.php' : "process_article.php?id={$article->getId()}" ?>" method="POST">
                        <?php
                        if (!empty($article)) {
                            echo "<h1 style='color: white'>Edit article {$article->getTitle()}</h1>";
                            ?>
                            <input type="hidden" name="id" value="<?php echo $article->getId(); ?>">
                            <?php
                        } else {
                            ?>
                        <?php
                            echo "<h1 style='color: white'> Create new article</h1>";
                        }
                        ?>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="<?php echo !empty($article) && $article instanceof \Entity\Article ? $article->getTitle() : null; ?>"
                                   placeholder="Enter your first name">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description"  rows=10 class="form-control"
                                      placeholder="Enter your last name"><?php echo !empty($article) && $article instanceof \Entity\Article ? $article->getDescription() : null; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>File</label>
                            <input type="file" name="file">
                        </div>

                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">

                        <div class="form-group">
                            <?php
                            if (!empty($article)):
                                ?>
                                <button type="submit" class=" btn btn-info" name="update">Update</button>
                            <?php else: ?>
                                <button type="submit" class=" btn btn-primary" name="save">Save</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
