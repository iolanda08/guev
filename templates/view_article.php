<?php
$article = !empty($article) && $article instanceof \Entity\Article ? $article : null;
if (!$article instanceof \Entity\Article) {
    return;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $article->getTitle()?></title>
</head>

<body>

</body>
</html>