<?php
    
namespace HtProfieImage\Controller;

use HtProfieImage\Form\ProfileImageForm;
use HtProfieImage\Form\ProfileImageInputFilter;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ImageUploadController
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

                    return new JsonModel(array(
                        'uploaded' => true
                    ));                    
                } 
                $image_uploaded = true;
            } else {
                if ($request->isXmlHttpRequest()) {

                    return new JsonModel(array(
                        'error' => true,
                        'messages' = $form->getMessages()
                    ));                    
                }
                                 
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'image_uploaded' = $image_uploaded
        ));
    }

    protected function getService()
    {
        return $this->getServiceLocator()->get('HtProfieImage\ImageUploadService');
    }
}