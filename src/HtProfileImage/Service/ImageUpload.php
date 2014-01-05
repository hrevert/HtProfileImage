<?php

namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use HtProfileImage\Form\ProfileImageForm;
use HtProfileImage\Form\ProfileImageInputFilter;
use HtProfileImage\Form\ProfileImageValidator;
use ZfcBase\EventManager\EventProvider;
use HCommons\Image\ResizingInterface;

class ImageUpload extends EventProvider
{
    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    public function uploadImage(UserInterface $user, ProfileImageForm $form, array $files)
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
            try {
                $file = $inputFilter->getUploadTarget();
                $newFileName = $this->getServiceLocator()->get('HtProfileImage\StorageModel')->getUserImage($user->getId());
                $resizer = $this->getServiceLocator()->get('HtProfileImage\StorageResizerProvider')->getStorageResizer();
                if (!$resizer instanceof ResizingInterface) {
                    rename($file, $newFileName);
                } else {
                    $resizer->setImagePath($file);
                    $thumb = $resizer->getPhpThumb();
                    $thumb->save($newFileName);
                    unlink($file);                     
                }
                $this->getEventManager()->trigger('imageUploaded', null, array(
                    'file_name' => $newFileName,
                    'user' => $user
                ));
                return true;           
            } catch (\Exception $e) {
                
            }
           
        }
        return false;        
    }
}
