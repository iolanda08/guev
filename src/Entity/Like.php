<?php

namespace Entity;

class Like extends AbstractEntity
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


    public function geArticleId() {
        return  $this->article_id;
    }
    public function geUserId() {
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