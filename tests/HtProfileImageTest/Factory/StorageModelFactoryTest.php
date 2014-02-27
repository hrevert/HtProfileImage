<?php
namespace HtProfileImageTest\Factory;

use HtProfileImage\Factory\StorageModelFactory;
use Zend\ServiceManager\ServiceManager;
use HtProfileImage\Options\ModuleOptions;

class StorageModelFactoryTest extends \PHPUnit_Framework_Testcase
{
    public function testFactory()
    {
        $seviceManager = new ServiceManager();
        $seviceManager->setService('HtProfileImage\ModuleOptions', new ModuleOptions);
        $factory = new StorageModelFactory;
        $this->assertInstanceOf('HtProfileImage\Model\StorageModel', $factory->createService($seviceManager));
    }
}
