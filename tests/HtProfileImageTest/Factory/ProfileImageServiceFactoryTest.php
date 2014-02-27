<?php
namespace HtProfileImageTest\Factory;

use HtProfileImage\Factory\ProfileImageServiceFactory;
use Zend\ServiceManager\ServiceManager;

class ProfileImageServiceFactoryTest extends \PHPUnit_Framework_Testcase
{
    public function testFactory()
    {
        $seviceManager = new ServiceManager();
        $factory = new ProfileImageServiceFactory;
        $this->assertInstanceOf('HtProfileImage\Service\ProfileImageService', $factory->createService($seviceManager));
    }
}
