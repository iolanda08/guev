<?php

namespace Service;

use Entity\User;

class ProcessUserService
{
    use DatabaseTrait;

    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    public function getCurrentUser()
    {
        if (!empty($_SESSION['user_id'])) {
            $currentUser = $this->loadUser($_SESSION['user_id']);
        }

        if (empty($currentUser)) {
            $currentUser = $this->createAnonymousUser();
        }

        return $currentUser;

    }

    public function  deleteToken(User $user)
    {
        $user->setToken(null);
        $user->save();
    }

    public function getSubscribers() {
        $ids = $this->mysqli->query("SELECT id from users where subscriber = 1")->fetch_all();
        $ids = array_column($ids, 0);

        $users = [];
        foreach ($ids as $id) {
            $users[] = $this->loadUser($id);
        }

        return $users;
    }

    public function saveUserFromPost()
    {
        $user = User::create([
            'firstname' => $this->mysqli->real_escape_string($_POST['firstname']),
            'lastname' => $this->mysqli->real_escape_string($_POST['lastname']),
            'email' => $this->mysqli->real_escape_string($_POST['email']),
            'passwordHash' => md5($this->mysqli->real_escape_string($_POST['password'])),
            'role' => 'subscriber',
        ]);
        $user->save();

        $user = $this->getUserByEmail($this->mysqli->real_escape_string($_POST['email']));

        $_SESSION['message'] = "Record has been saved";
        $_SESSION['msg_type'] = "success";
        return $user;
    }

    public function createAnonymousUser()
    {
        $user = User::create([[
            'role' => 'anonymous'
        ]]);
        return $user;
    }

    public function updateUserFromPost()
    {
        $id = $this->mysqli->real_escape_string($_POST['id']);
        $user = $this->loadUser($id);
        $user->setFirstname($this->mysqli->real_escape_string($_POST['firstname']))
            ->setLastname($this->mysqli->real_escape_string($_POST['lastname']))
            ->setEmail($this->mysqli->real_escape_string($_POST['email']))
            ->setPassword($this->mysqli->real_escape_string($_POST['password']));


        $user->save();
    }

    public function deleteUser($id)
    {
        $this->mysqli->query("DELETE from users where id = '$id'");
    }

    public function unsubscribeUser($id)
    {
        $this->mysqli->query("Update users set subscriber=null where id='$id' ");
    }

    public function loadUser($id)
    {
        $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT * from users where id = '$id'")->fetch_assoc();
        if (empty($result)) {
            return null;
        }

        return User::create($result);
    }

    public function loginUser()
    {
        $email = $this->mysqli->real_escape_string($_POST['email']);
        $password = $this->mysqli->real_escape_string($_POST['password']);
        $result = $this->mysqli->query("SELECT id FROM users WHERE email='$email'")->fetch_assoc();
        if (empty($result['id'])) {
            $_SESSION['message'] = "the email is incorrect";
            $_SESSION['msg_type'] = "danger";
        } else {
            $id = $result['id'];
            $pasResult = $this->mysqli->query("SELECT passwordHash FROM users WHERE id=$id ")->fetch_assoc();
            $hash = $pasResult['passwordHash'];
            if (md5($password) != $hash) {
                $_SESSION['message'] = "Email and Password do not match";
                $_SESSION['msg_type'] = "danger";
            } else {
                $_SESSION['user_id'] = $id;
                $_SESSION['message'] = "Successfully login";
                $_SESSION['msg_type'] = "success";
                header("location: index.php");
                return true;
            }

        }

        return false;
    }

    public function getUserByEmail($email)
    {
        $email = $this->mysqli->real_escape_string($email);
        $result = $this->mysqli->query("SELECT id FROM users WHERE email='$email'")->fetch_assoc();
        if (empty($result['id'])) {
            return null;
        }
        return $this->loadUser($result['id']);

    }

    public function getUserByToken($token)
    {
        $result= $this->mysqli->query("SELECT id FROM users WHERE token='$token'")->fetch_assoc();
        if (empty ($result['id'])) {
            return null;
        }
        return  $this->loadUser($result['id']);
    }

    public function resetUserPassword(User $user)
    {
        $token = sha1(mt_rand(1, 90000) . 'SALT');
        $user->setToken($token);
        $user->save();

        $mailer = new Mailer();
        $mailer->notifyUserNewToken($user);
    }


    protected function getUserIds()
    {
        $ids = $this->mysqli->query("SELECT id from users")->fetch_all();
        return array_column($ids, 0);
    }

    public function getAllUsers()
    {
        $ids = $this->getUserIds();

        $users = [];
        foreach ($ids as $id) {
            $users[] = $this->loadUser($id);
        }

        return $users;
    }

}