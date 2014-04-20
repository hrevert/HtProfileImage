<?php
namespace HtProfileImage\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\Service\CacheManager;

class CacheManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CacheManager(
            $serviceLocator->get('HtImgModule\Service\CacheManager'),
            $serviceLocator->get('HtProfileImage\StorageModel')
        );
    }
}
