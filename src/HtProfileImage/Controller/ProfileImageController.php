<?php
    
namespace HtProfileImage\Controller;

use HtProfileImage\Form\ProfileImageForm;
use Zend\View\Model;
use Zend\Mvc\Controller\AbstractActionController;
use HtProfileImage\Service\ProfileImageServiceInterface;

class ProfileImageController extends AbstractActionController
{
    protected $profileImageService;

    protected $options;

    public function __construct(ProfileImageServiceInterface $profileImageService)
    {
        $this->profileImageService = $profileImageService;
    }

    public function uploadAction()
    {
        $authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        if (!$authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }
        $user = $authenticationService->getIdentity();
        $options = $this->getOptions();
        $form = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');
        $request = $this->getRequest();
        $imageUploaded = false;
        if ($request->isPost()) {
            if ($this->profileImageService->uploadImage($user, $request->getFiles()->toArray())) {
                if ($request->isXmlHttpRequest()) {
                    return new Model\JsonModel(array(
                        'uploaded' => true
                    ));                    
                } elseif ($options->getPostUploadRoute()) {
                        return call_user_func_array(array($this->redirect(), 'toRoute'), (array) $options->getPostUploadRoute());
                }
                $imageUploaded = true;
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
            'imageUploaded' => $imageUploaded,
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
                if ($gender === null) {
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

    public function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions');
        }

        return $this->options;
    }
}