<?php
namespace HtProfileImageTest\Factory;

use HtProfileImage\Factory\CacheManagerFactory;
use Zend\ServiceManager\ServiceManager;

class CacheManagerFactoryTest extends \PHPUnit_Framework_Testcase
{
    public function testFactory()
    {
        $seviceManager = new ServiceManager();
        $seviceManager->setService('HtImgModule\Service\CacheManager', $this->getMock('HtImgModule\Service\CacheManagerInterface'));
        $seviceManager->setService('HtProfileImage\StorageModel', $this->getMock('HtProfileImage\Model\StorageModelInterface'));
        $factory = new CacheManagerFactory;
        $cacheManager = $factory->createService($seviceManager);
        $this->assertInstanceOf('HtProfileImage\Service\CacheManager', $cacheManager);

    }
}
