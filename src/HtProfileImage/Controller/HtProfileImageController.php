<?php
    
namespace HtProfileImage\Controller;

use HtProfileImage\Form\ProfileImageForm;
use Zend\View\Model;
use HCommons\View\Model\ImageModel;
use HCommons\Model\GenderManager;
use Zend\Mvc\Controller\AbstractActionController;

class HtProfileImageController extends AbstractActionController
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
                return $this->redirect()->toRoute('zfcuser'); 
                $image_uploaded = true;
            } else {
                if ($request->isXmlHttpRequest()) {
                    return new Model\JsonModel(array(
                        'error' => true,
                        'messages' => $form->getMessages()
                    ));                    
                }
                                 
            }
        }

        return new Model\ViewModel(array(
            'form' => $form,
            'image_uploaded' => $image_uploaded,
            'user' => $user
        ));
    }

    protected function getService()
    {
        return $this->getServiceLocator()->get('HtProfileImage\ImageUploadService');
    }

    public function displayImageAction()
    {
        $id = $this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->notFoundAction();
        }
        $gender = $this->params()->fromRoute('gender', null);
        $size = $this->params()->fromRoute('size', null);
        $options = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions');
        $storageModel = $this->getServiceLocator()->get('HtProfileImage\StorageModel');
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
                $size = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions')->getDefaultImageSize();
            }
            $thumb->resize($size, $size);
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