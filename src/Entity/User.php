<?php

namespace Entity;

class User extends AbstractEntity
{
    /** @var string */
    protected $firstname;

    /** @var string */
    protected $lastname;

    /** @var string */
    protected $email;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $role;

    /** @var string */
    protected $subscriber;

    /** @var string|null */
    protected $token;



    public function __construct($properties)
    {
        parent::__construct();
        foreach ($properties as $index => $value) {
            if (property_exists($this, $index)) {
                $this->$index = $value;
            }
        }
    }

    public function getUserId()
    {
        return $this->id;
    }

    public function setUserId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function isAnounymous() {
        return empty($this->role) || $this->role == 'anonymous';
    }
    public function isSubscriber() {
        return !empty($this->subscriber);
    }

    public function subscribe() {
        $this->subscriber = true;
        $this->save();
    }

    public function unSubscribe() {
        $this->subscriber = null;
        $this->save();
    }

    public function setPassword($password)
    {
        $this->passwordHash = md5($password);
        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getToken() {
        return  $this->token;
    }

    protected function getTableName()
    {
        return 'users';
    }

    protected function getTableColumns(): array
    {
        //column name => entity property
        return [
            'id' => 'id',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'email' => 'email',
            'passwordHash' => 'passwordHash',
            'role' => 'role',
            'token' => 'token',
            'subscriber' => 'subscriber',
        ];
    }
}