<?php
namespace HtProfileImage\Entity;

use HtProfileImage\Exception;

class User extends \ZfcUser\Entity\User implements UserGenderInterface
{
    const GENDER_MALE = 1;

    const GENDER_FEMALE = 0;

    /**
     * @var int
     */
    protected $gender;

    /**
     * Sets gender
     *
     * @param  int                                $gender
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function setGender($gender)
    {
        if (!in_array($gender, [static::GENDER_MALE, static::GENDER_FEMALE])) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be one of %s or %s, %s provided instead',
                    __METHOD__,
                    static::GENDER_MALE,
                    static::GENDER_FEMALE,
                    $gender
                )
            );
        }

        $this->gender = (int) $gender;
    }

    /**
     * Gets gender
     *
     * @return int $gender
     */
    public function getGender()
    {
        return $this->gender;
    }
}
