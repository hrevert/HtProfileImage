<?php

namespace HtProfileImage\Controller;

use Zend\View\Model;
use Zend\Mvc\Controller\AbstractActionController;
use HtProfileImage\Service\ProfileImageServiceInterface;
use HtImgModule\View\Model\ImageModel;
use Negotiation\FormatNegotiator;

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

        $user = $this->getUser();
        if (!$user) {
            return $this->notFoundAction();
        }
        $options = $this->getOptions();
        $form = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        $imageUploaded = false;
        if ($request->isPost()) {
            $negotiator   = new FormatNegotiator();
            $format = $negotiator->getBest(
                $request->getHeader('Accept')->getFieldValue(),
                ['application/json', 'text/html']
            );
            if ($this->profileImageService->storeImage($user, $request->getFiles()->toArray())) {
                if ($format->getValue() === 'application/json') {
                    return new Model\JsonModel([
                        'uploaded' => true
                    ]);
                } elseif ($options->getPostUploadRoute()) {
                        return call_user_func_array([$this->redirect(), 'toRoute'], (array) $options->getPostUploadRoute());
                }
                $imageUploaded = true;
            } else {
                $response = $this->getResponse();
                /** @var \Zend\Http\Response $response */
                $response->setStatusCode(400);
                if ($format->getValue() === 'application/json') {
                    return new Model\JsonModel([
                        'error' => true,
                        'messages' => $form->getMessages()
                    ]);
                }

            }
        }

        return new Model\ViewModel([
            'form' => $form,
            'imageUploaded' => $imageUploaded,
            'user' => $user
        ]);
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

    public function deleteAction()
    {
        if (!$this->getOptions()->getEnableImageDelete()) {
            return $this->notFoundAction();
        }

        $authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        if (!$authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $user = $this->getUser();
        if (!$user) {
            return $this->notFoundAction();
        }
        $this->profileImageService->deleteUserImage($user);

        return call_user_func_array([$this->redirect(), 'toRoute'], (array) $this->getOptions()->getPostImageDeleteRoute());
    }

    /**
     * @return \ZfcUser\Entity\UserInterface|null
     */
    protected function getUser()
    {
        $authenticationService = $this->getServiceLocator()->get('zfcuser_auth_service');
        /** @var \ZfcUser\Entity\UserInterface $user */
        $user = $authenticationService->getIdentity();

        $userId = $this->params()->fromRoute('userId', null);
        if ($userId !== null) {
            $currentUser = $user;
            $user = $this->getUserMapper()->findById($userId);
            if (!$user) {
                return null;
            }
            if (!$this->getOptions()->getEnableInterUserImageUpload() && ($user->getId() !== $currentUser->getId())) {
                return null;
            }
        }

        return $user;         
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
