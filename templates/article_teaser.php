<?php
$article = !empty($article) && $article instanceof \Entity\Article ? $article : null;
if (!$article instanceof \Entity\Article) {
    return;
}
?>

<div class="col">
    <div class="card shadow-sm">
        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Article" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Article</text></svg>

        <div class="card-body">
            <p class="card-text"><?php echo $article->getTitle() ?> </p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                   <button type="button" class="btn btn-sm btn-outline-secondary"> <a href="process_article.php?id=<?php echo $article->getId() ?>">Edit real</a></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"><a href="view_article.php?id=<?php echo $article->getId() ?>">View</a></button>
                </div>
                <small class="text-muted">3 mins</small>
            </div>
        </div>
    </div>
</div>