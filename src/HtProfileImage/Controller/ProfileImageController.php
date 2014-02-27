<?php

namespace HtProfileImage\Controller;

use HtProfileImage\Form\ProfileImageForm;
use Zend\View\Model;
use Zend\Mvc\Controller\AbstractActionController;
use HtProfileImage\Service\ProfileImageServiceInterface;
use HtImgModule\View\Model\ImageModel;

class ProfileImageController extends AbstractActionController
{
    /**
     * @var ProfileImageServiceInterface
     */
    protected $profileImageService;

    /**
     * @var \HtProfileImage\Options\ModuleOptionsInterface
     */
    protected $options;

    /**
     * @var \ZfcUser\Mapper\UserInterface
     */
    protected $userMapper;

    /**
     *  Constructor
     *
     * @param ProfileImageServiceInterface $profileImageService
     */
    public function __construct(ProfileImageServiceInterface $profileImageService)
    {
        $this->profileImageService = $profileImageService;
    }

    /**
     * Uploads User Image
     */
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
            if ($this->profileImageService->storeImage($user, $request->getFiles()->toArray())) {
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

    /**
     * Displays User Image
     */
    public function displayAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $filter = $this->params()->fromRoute('filter', null);
        if (!$id) {
            return $this->notFoundAction();
        }
        $user = $this->getUserMapper()->findById($id);
        if (!$user) {
            return $this->notFoundAction();
        }
        $image = $this->profileImageService->getUserImage($user, $filter);

        return new ImageModel($image);
    }

    /**
     * Gets options
     *
     * @return \HtProfileImage\Options\ModuleOptionsInterface
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->getServiceLocator()->get('HtProfileImage\ModuleOptions');
        }

        return $this->options;
    }

    /**
     * Gets userMapper
     *
     * @return \ZfcUser\Mapper\UserInterface
     */
    public function getUserMapper()
    {
        if (!$this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }

        return $this->userMapper;
    }
}
