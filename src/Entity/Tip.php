<?php

namespace Entity;

class Tip extends AbstractEntity
{
    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var int */
    protected $userId;

    /** @var string */
    protected $talent;

    /** @var string */
    protected $fbLink;

    /** @var string */
    protected $instaLink;

    /** @var string */
    protected $phone;

    public function __construct($properties)
    {
        parent::__construct();
        foreach ($properties as $index => $value) {
            if (property_exists($this, $index)) {
                $this->$index = $value;
            }
        }
    }
    public function getTipId()
    {
        return $this->id;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    public function setTalent($talent)
    {
        $this->talent = $talent;
        return $this;
    }

    public function getTalent()
    {
        return $this->talent;
    }
    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
        return $this;
    }

    public function getFbLink()
    {
        return $this->fbLink;
    }
    public function setInstaLink($instaLink)
    {
        $this->instaLink = $instaLink;
        return $this;
    }

    public function getInstaLink()
    {
        return $this->instaLink;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }


    protected function getTableName()
    {
        return 'tips';
    }

    protected function getTableColumns(): array
    {
        //column name => entity property
        return [
            'id' => 'id',
            'user_id' => 'userId',
            'artist_first_name' => 'firstName',
            'artist_last_name' => 'lastName',
            'talent' => 'talent',
            'facebook_link' => 'fbLink',
            'instagram_link' => 'instaLink',
            'phone_number' => 'phone',
        ];
    }

}