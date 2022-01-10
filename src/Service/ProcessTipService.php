<?php

namespace Service;

use Entity\Tip;

class ProcessTipService
{
    use DatabaseTrait;

    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = $this->connect();
    }

    public function saveTipFromPost()
    {
        $userService = new ProcessUserService();
        $currentUser = $userService->getCurrentUser();
        $tip = Tip::create([
            'user_id' => $currentUser->getUserId(),
            'firstName' => $this->mysqli->real_escape_string($_POST['firstName']),
            'lastName' => $this->mysqli->real_escape_string($_POST['lastName']),
            'talent' => $this->mysqli->real_escape_string($_POST['talent']),
            'fbLink' => ($this->mysqli->real_escape_string($_POST['fbLink'])),
            'instaLink' => ($this->mysqli->real_escape_string($_POST['instaLink'])),
            'phone' => $this->mysqli->real_escape_string($_POST['phone']),
        ]);
        $tip->save();

        return $tip;
    }
}