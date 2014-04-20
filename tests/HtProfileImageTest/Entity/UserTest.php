<?php
namespace HtProfileImageTest\Entity;

use HtProfileImage\Entity\User;

class UserTest extends \PHPUnit_Framework_Testcase
{
    public function testSettersAndGetters()
    {
        $user = new User();
        $user->setGender(User::GENDER_FEMALE);
        $this->assertEquals(User::GENDER_FEMALE, $user->getGender());
        $user->setGender(User::GENDER_MALE);
        $this->assertEquals(User::GENDER_MALE, $user->getGender());
    }

    public function testGetExceptionWithInvalidGender()
    {
        $user = new User();
        $this->setExpectedException('HtProfileImage\Exception\InvalidArgumentException');
        $user->setGender('234234');
    }
}
