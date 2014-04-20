<?php
namespace HtProfileImageTest\Factory;

use HtProfileImage\Factory\ModuleOptionsFactory;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_Testcase
{
    public function testFactoryWithoutConfig()
    {
        $seviceManager = new ServiceManager();
        $factory = new ModuleOptionsFactory;
        $seviceManager->setService('Config', []);
        $this->assertInstanceOf('HtProfileImage\Options\ModuleOptions', $factory->createService($seviceManager));
    }

    public function testFactoryWithConfig()
    {
        $seviceManager = new ServiceManager();
        $factory = new ModuleOptionsFactory;
        $seviceManager->setService('Config', ['htprofileimage' => []]);
        $this->assertInstanceOf('HtProfileImage\Options\ModuleOptions', $factory->createService($seviceManager));
    }
}
