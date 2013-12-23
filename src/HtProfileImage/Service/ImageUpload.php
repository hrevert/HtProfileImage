<?php

namespace HtProfileImage\Service;

use ZfcUser\Entity\User;
use HtProfieImage\Form\ProfileImageForm;

class ImageUpload
{
    use \Zend\ServiceManger\ServiceLocatorAwareTrait;

    public function uploadImage(User $user, ProfileImageForm $form, array $files)
    {
        $validator = new ProfileImageValidator();
        $form->setData($files);
        $form->setInputFilter($validator);
        if ($form->isValid()) {
            $moduleOptions = $this->getServiceLocator()->get('HtProfieImage\ModuleOptions');
            $inputFilter = new ProfileImageInputFilter($moduleOptions->getUploadDirectory());
            $inputFilter->init();
            $inputFilter->setUser($user);
            $form->setInputFilter($inputFilter);
            $result = $form->isValid();
            try {
                $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                $file = $inputFilter->getTarget();
                $thumb = $thumbnailer->create($file);
                $newFileName = $this->getServiceLocator()->get('HtProfieImage\StorageModel')->getUserImage($user->getId());
                $thumb->cropFromCenter($moduleOptions->getStoredImageSize())
                $thumb->save($newFileName); 
                unlink($file);
                return true;           
            } catch (\Exception $e) {
                
            }
           
        }
        return false;        
    }
}
