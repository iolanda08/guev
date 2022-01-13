<?php

namespace Entity;

class Saved extends AbstractEntity
{
    /** @var int */
    protected $article_id;

    /** @var int */
    protected $user_id;

    public function __construct($properties)
    {
        parent::__construct();
        foreach ($properties as $index => $value) {
            if (property_exists($this, $index)) {
                $this->$index = $value;
            }
        }
    }

    public function setArticleId($id)
    {
        $this->article_id = $id;
        return $this;
    }

    public function getArticleId() {
        return  $this->article_id;
    }

    public function setUserId($id)
    {
        $this->user_id = $id;
        return $this;
    }

    public function getUserId() {
        return  $this->user_id;
    }

    protected function getTableName()
    {
        return 'saved';
    }

    protected function getTableColumns(): array
    {
        //column name => entity property
        return [
            'article_id' => 'article_id',
            'user_id' => 'user_id',
        ];
    }
}