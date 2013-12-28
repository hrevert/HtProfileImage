<?php

namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use HtProfileImage\Form\ProfileImageForm;
use HtProfileImage\Form\ProfileImageInputFilter;
use HtProfileImage\Form\ProfileImageValidator;
use ZfcBase\EventManager\EventProvider;

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
            //try {
                //$thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                $file = $inputFilter->getUploadTarget();
                //$thumb = $thumbnailer->create($file);
                $newFileName = $this->getServiceLocator()->get('HtProfileImage\StorageModel')->getUserImage($user->getId());
                //$thumb->adaptiveResize($moduleOptions->getStoredImageSize(), $moduleOptions->getStoredImageSize());
                $resizingOptions = $this->getServiceLocator()->get('HtProfileImage\StorageResizerProvider')->getStorageResizer();
                if (!$resizingOptions) {
                    rename($file, $newFileName);
                } else {
                    $resizer = new $resizingOptions['name'];
                    $resizer->setOptions($resizingOptions['options']);
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
            //} catch (\Exception $e) {
                
            //}
           
        }
        return false;        
    }
}
