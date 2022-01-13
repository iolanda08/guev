<?php

namespace Service;

use Entity\Like;

class ProcessLikeService
{
    use DatabaseTrait;

    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    public function saveLike($article_id, $user_id)
    {
        $result = $this->mysqli->query("INSERT INTO likes VALUES ('$article_id', '$user_id')");
        return $result;
    }
    public function deleteLike($article_id, $user_id)
    {
        $result = $this->mysqli->query("DELETE from likes where article_id={$article_id} and user_id={$user_id}");
        return $result;
    }

}