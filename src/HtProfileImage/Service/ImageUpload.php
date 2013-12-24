<?php

namespace HtProfileImage\Service;

use ZfcUser\Entity\User;
use HtProfileImage\Form\ProfileImageForm;
use HtProfileImage\Form\ProfileImageInputFilter;
use HtProfileImage\Form\ProfileImageValidator;

class ImageUpload
{
    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    public function uploadImage(User $user, ProfileImageForm $form, array $files)
    {
        $validator = new ProfileImageValidator();
        $form->setData($files);
        $form->setInputFilter($validator);
        if ($form->isValid()) {
            $moduleOptions = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions');
            $inputFilter = new ProfileImageInputFilter($moduleOptions->getUploadDirectory());
            $inputFilter->setUser($user);
            $inputFilter->init();
            $form->setInputFilter($inputFilter);
            $result = $form->isValid();
            //try {
                $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                $file = $inputFilter->getUploadTarget();
                $thumb = $thumbnailer->create($file);
                $newFileName = $this->getServiceLocator()->get('HtProfileImage\StorageModel')->getUserImage($user->getId());
                $thumb->adaptiveResize($moduleOptions->getStoredImageSize());
                $thumb->save($newFileName); 
                unlink($file);
                return true;           
            //} catch (\Exception $e) {
                
            //}
           
        }
        return false;        
    }
}
