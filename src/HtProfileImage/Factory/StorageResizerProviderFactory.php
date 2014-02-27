<?php

namespace HtProfileImage\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\Model\StorageResizerProvider;

class StorageResizerProviderFactory implements FactoryInterface
{
    /**
     * gets StorageResizerProvider to obtain storage resizer
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return StorageResizerProvider
     */
     public function createService(ServiceLocatorInterface $sm)
     {
         return new StorageResizerProvider($sm->get('HtProfileImage\ModuleOptions'));
     }
}
