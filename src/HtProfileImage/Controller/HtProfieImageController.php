<?php
    
namespace HtProfieImage\Controller;

use HtProfieImage\Form\ProfileImageForm;
use HtProfieImage\Form\ProfileImageInputFilter;
use Zend\View\Model;
use HCommons\View\Model\ImageModel;
use HCommons\Model\GenderManager;

class HtProfieImageController
{
    public function profileAction()
    {
        $user = $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity();
        $form = new ProfileImageForm();
        $request = $this->getRequest();
        $image_uploaded = false;
        if ($request->isPost()) {
            if ($this->getService()->uploadImage($user, $form, $request->getFiles()->toArray())) {
                if ($request->isXmlHttpRequest()) {
                    return new Model\JsonModel(array(
                        'uploaded' => true
                    ));                    
                } 
                $image_uploaded = true;
            } else {
                if ($request->isXmlHttpRequest()) {

                    return new Model\JsonModel(array(
                        'error' => true,
                        'messages' = $form->getMessages()
                    ));                    
                }
                                 
            }
        }

        return new Model\ViewModel(array(
            'form' => $form,
            'image_uploaded' = $image_uploaded
        ));
    }

    protected function getService()
    {
        return $this->getServiceLocator()->get('HtProfieImage\ImageUploadService');
    }

    public function displayImageAction()
    {
        $id = $this->params()->fromRoute('user_id', null);
        if (!$id) {
            return $this->notFoundAction();
        }
        $gender = $this->params()->fromRoute('gender', null);
        $size = $this->params()->fromRoute('size', null);
        $options = $this->getServiceLocator()->get('HtProfieImage\ModuleOptions');
        $storageModel = $this->getServiceLocator()->get('HtProfieImage\StorageModel');
        if (!$storageModel->userImageExists($id)) {
            if ($options->getEnableGender()) {
                if (!$gender) {
                    $user = $this->getUser($id);
                    $gender = $user->getGender();
                }
                if ($gender === GenderManager::GENDER_FEMALE) {
                    $file = $options->getFemaleImage();
                } else {
                    $file = $options->getMaleImage();
                }
            } else {
                $file = $options->getDefaultImage();
            }
        } else {
            $file = $storageModel->getUserImage($id);
        }
        $vm =  new ImageModel();
        if ($options->getServeCroppedImage()) {
            $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
            $thumb = $thumbnailer->create($file);
            if (!$size) {
                $size = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions')->getDefaultSize();
            }
            $thumb->cropFromCenter($size);
            $vm->setPhpThumb($thumb);
        } else {
            $vm->setFileName($file);
        }
        return $vm;
    }

    protected function getUser($id)
    {
        return $this->getServiceLocator()->get('zfcuser_user_mapper')->findById($id);
    }
}