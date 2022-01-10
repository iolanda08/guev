<?php

namespace Entity;

class Article extends AbstractEntity
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var int */
    protected $authorId;

    /** @var string */
    protected $created;

    /** @var int */
    protected $picId;

    protected $body;

    /** @var integer */
    protected $tipsId;

    public function __construct(array $properties)
    {
        parent::__construct();
        foreach ($properties as $index => $value) {
            $this->$index = $value;
            if (property_exists($this, $index)) {
                $this->$index = $value;
            } else {
//                var_dump($index); //@todo
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getTipsId() {
        return $this->tipsId;
    }

    public function getAuthorId() {
        return $this->authorId;
    }

    protected function getTableName()
    {
        return 'article';
    }

    protected function getTableColumns(): array
    {
        //column name => entity property
        return [
            'id' => 'id',
            'title' => 'title',
            'description' => 'description',
            'pic_id' => 'picId',
            'tips_id' => 'tipsId',
            'author_id' => 'authorId',
            'created' => 'created',
        ];
    }

}