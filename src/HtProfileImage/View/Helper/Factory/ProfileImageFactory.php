<?php
namespace HtProfileImage\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\View\Helper\ProfileImage;

class ProfileImageFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $helpers)
    {
        $serviceLocator = $helpers->getServiceLocator();
        $options = $serviceLocator->get('HtProfileImage\ModuleOptions');
        $helper = new ProfileImage(
            $options,
            $serviceLocator->get('HtProfileImage\StorageModel'),
            $serviceLocator->get('zfcuser_user_mapper')
        );
        if ($options->getEnableCache()) {
            $helper->setCacheManager($serviceLocator->get('HtProfileImage\Service\CacheManager'));
        }

        return $helper;
    }
}
