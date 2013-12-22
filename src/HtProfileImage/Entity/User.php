<?php

namespace HtProfileImage\Entity;

class User extends \ZfcUser\Entity\User
{
    protected $gender;

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }
}
