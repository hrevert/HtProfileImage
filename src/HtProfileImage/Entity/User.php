<?php
namespace HtProfileImage\Entity;

use HtProfileImage\Exception;

class User extends \ZfcUser\Entity\User
{
    const GENDER_MALE = 1;

    const GENDER_FEMALE = 0;

    protected $gender;

    public function setGender($gender)
    {
        if (!in_array($gender, [static::GENDER_MALE, static::GENDER_FEMALE])) {
            throw new Exception\InvalidArgumentException();
        }
        $this->gender = (int) $gender;
    }

    public function getGender()
    {
        return $this->gender;
    }
}
