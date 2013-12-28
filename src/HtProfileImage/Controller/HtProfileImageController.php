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
        $authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        if (!$authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }
        $user = $authenticationService->getIdentity();
        $options = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions');
        $form = new ProfileImageForm();
        $request = $this->getRequest();
        $image_uploaded = false;
        if ($request->isPost()) {
            if ($this->getService()->uploadImage($user, $form, $request->getFiles()->toArray())) {
                if ($request->isXmlHttpRequest()) {
                    return new Model\JsonModel(array(
                        'uploaded' => true
                    ));                    
                } elseif ($options->getPostUploadRoute()) {
                        return call_user_func_array(array($this->redirect(), 'toRoute'), (array) $options->getPostUploadRoute());
                }
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
                $size = $options->getDefaultImageSize();
            }
            $thumb->adaptiveResize($size, $size);
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