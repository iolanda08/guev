<?php

namespace Service;

use Entity\Article;
use Entity\User;

class ProcessArticleService
{
    use DatabaseTrait;

    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    public function importArticleFromRow($csvRow)
    {

        try {
            $title = $csvRow[0];
            $pic_id = !empty($this->mysqli->real_escape_string($csvRow[1])) ? $this->mysqli->real_escape_string($csvRow[1]) : null;
            $description = $csvRow[2];
            $author_id = empty($csvRow[3]) ? null : (int) $csvRow[3];
            $tips_id = empty($csvRow[4]) ? null : (int)$csvRow[4];

            $article = Article::create([
                'title' => $this->mysqli->real_escape_string($title),
                'pic_id' => $pic_id,
                'description' => $this->mysqli->real_escape_string($description),
                'author_id' => $author_id,
                'tips_id' => $tips_id,
                'created' => date('Y-m-d'),
            ]);
            $article->save();
        }
        catch (\Throwable $e) {
        }

        $_SESSION['message'] = "Record has been saved";
        $_SESSION['msg_type'] = "success";
        return $article;
    }

    protected function getArticleIds()
    {
        $ids = $this->mysqli->query("SELECT id from article")->fetch_all();
        return array_column($ids, 0);
    }

    public function loadArticle($id)
    {
        $result = $this->mysqli->query("SELECT * from article where id = '$id'")->fetch_assoc();
        if (empty($result)) {
            return null;
        }

        return Article::create($result);
    }

    public function getCurrentArticle() {
        if (empty($_GET['id'])) {
            return null;
        }

        return $this->loadArticle($_GET['id']);
    }


    public function updateArticleFromPost()
    {
        $id = $this->mysqli->real_escape_string($_POST['id']);
        $article = $this->loadArticle($id);
        $article->setTitle($this->mysqli->real_escape_string($_POST['title']))
            ->setDescription($this->mysqli->real_escape_string($_POST['description']));

        $article->save();

        return $article;
    }

    public function saveArticleFromPost()
    {
        $userService = new ProcessUserService();
        $currentUser = $userService->getCurrentUser();

        $article = Article::create([
            'title' => $this->mysqli->real_escape_string($_POST['title']),
            'description' => $this->mysqli->real_escape_string($_POST['description']),
            'created' => date('Y-m-d'),
            'author_id' => $currentUser->getUserId(),
        ]);
        $article->save();

        $article = $this->getArticleByTitle($article->getTitle());

        $_SESSION['message'] = "Record has been saved";
        $_SESSION['msg_type'] = "success";
        return $article;
    }

    public function getArticleByTitle($title) {

        $title = $this->mysqli->real_escape_string($title);
        $result = $this->mysqli->query("SELECT id FROM article WHERE title='$title'")->fetch_assoc();
        if (empty($result['id'])) {
            return null;
        }
        return $this->loadArticle($result['id']);

    }

    public function getAllArticles()
    {
        $ids = $this->getArticleIds();

        $articles = [];
        foreach ($ids as $id) {
            $articles[] = $this->loadArticle($id);
        }

        return $articles;
    }

}