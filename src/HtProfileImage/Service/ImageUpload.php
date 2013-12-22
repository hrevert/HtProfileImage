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
            $form->setInputFilter($inputFilter);
            $result = $form->isValid();
            try {
                $file = $inputFilter->getTarget();
                $manipulator = new SimpleImage($file);
                $manipulator->square_crop()->save($file.'.png'); 
                unlink($file);
                return true;           
            } catch (\Exception $e) {
                
            }
           
        }
        return false;        
    }
}