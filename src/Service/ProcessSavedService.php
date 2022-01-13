<?php

namespace Service;

use Entity\Saved;


class ProcessSavedService
{
    use DatabaseTrait;

    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    public function saveArticleInProfile($article_id, $user_id)
    {
        $result = $this->mysqli->query("INSERT INTO saved VALUES ('$article_id', '$user_id')");
        return $result;
    }
    public function unsaveArticleFromProfile($article_id, $user_id)
    {
        $result = $this->mysqli->query("DELETE from saved where article_id={$article_id} and user_id={$user_id}");
        return $result;
    }

}
