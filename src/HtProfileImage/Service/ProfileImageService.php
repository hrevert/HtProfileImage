<?php
namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use HtProfileImage\Form\ProfileImageForm;
use HtProfileImage\Form\ProfileImageInputFilter;
use HtProfileImage\Form\ProfileImageValidator;
use ZfcBase\EventManager\EventProvider;
use HtProfileImage\Entity\UserInterface as UserGender;

class ProfileImageService extends EventProvider implements ProfileImageServiceInterface
{
    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * @var \HtProfileImage\Options\ModuleOptionsInterface
     */
    protected $options;

    /**
     * @var \HtProfileImage\Model\StorageModelInterface
     */
    protected $storageModel;

    /**
     * @var \HtImgModule\Imagine\Filter\FilterManagerInterface
     */
    protected $filterManager;

    /**
     * @var \Imagine\Image\ImagineInterface
     */
    protected $imagine;

    /**
     * @var \HtProfileImage\Service\CacheManagerInterface
     */
    protected $cacheManager;

    /**
     * {@inheritDoc}
     */
    public function storeImage(UserInterface $user, array $files)
    {
        $form = $this->getServiceLocator()->get('HtProfileImage\ProfileImageForm');
        $this->getEventManager()->trigger(__FUNCTION__, $this, array(
            'files' => $files,
            'form' => $form,
            'user' => $user
        ));
        $validator = new ProfileImageValidator();
        $form->setData($files);
        $form->setInputFilter($validator);
        if ($form->isValid()) { // check if image is valid
            $inputFilter = new ProfileImageInputFilter($this->getOptions()->getUploadDirectory(), $user);
            $inputFilter->init();
            $form->setInputFilter($inputFilter);
            $result = $form->isValid();// upload the image
            $file = $inputFilter->getUploadTarget();
            $newFileName = $this->getStorageModel()->getUserImage($user);
            $filterAlias = $this->getOptions()->getStorageFilter();
            if (!$filterAlias) {
                rename($file, $newFileName); //no filter alias given, just rename
            } else {
                $filter = $this->getFilterManager()->getFilter($filterAlias);
                $image = $this->getImagine()->open($file);
                try {
                    $image = $filter->apply($image); // resize the image
                } catch (\Exception $e) {
                    return false;
                }
                $image->save($newFileName); // store the image
            }
            unlink($file);
            $this->deleteCache();
            $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('image_path' => $newFileName, 'user' => $user));

            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserImage(UserInterface $user, $filterAlias = null)
    {
        if ($this->getStorageModel()->userImageExists($user)) {
            $fileName = $this->getStorageModel()->getUserImage($user);
        } else {
            if ($this->getOptions()->getEnableGender()) {
                switch ($user->getGender()) {
                    case UserGender::GENDER_FEMALE:
                        $fileName = $this->getOptions()->getFemaleImage();
                        break;
                    default:
                        $fileName = $this->getOptions()->getMaleImage();
                        break;
                }
            } else {
                $fileName = $this->getOptions()->getDefaultImage();
            }
        }

        $image = $this->getImagine()->open($fileName);
        if (!$filterAlias) {
            $filterAlias = $this->getOptions()->getDisplayFilter();
        }
        if ($filterAlias) {
            $filter = $this->getFilterManager()->getFilter($filterAlias);
            $image = $filter->apply($image);
        }
        if ($this->getOptions()->getEnableCache()) {
            $this->getCacheManager()->createCache(
                $user,
                $filterAlias,
                $image
            );
        }

        return $image;
    }

    protected function deleteCache()
    {
        if ($this->getOptions()->getEnableCache()) {
            $user = $this->getServiceLocator()->get('zfcuser_auth_service')->getIdentity();
            foreach ($this->getOptions()->getDisplayFilterList() as $displayFilter) {
                if ($this->getCacheManager()->cacheExists($user, $displayFilter)) {
                    $this->getCacheManager()->deleteCache($user, $displayFilter);
                }                
            }
        }
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
     * Gets storageModel
     *
     * @return \HtProfileImage\Model\StorageModel
     */
    public function getStorageModel()
    {
        if (!$this->storageModel) {
            $this->storageModel = $this->getServiceLocator()->get('HtProfileImage\StorageModel');
        }

        return $this->storageModel;
    }

    /**
     * Gets filterManager
     *
     * @return \HtImgModule\Imagine\Filter\FilterManager
     */
    public function getFilterManager()
    {
        if (!$this->filterManager) {
            $this->filterManager = $this->getServiceLocator()->get('HtImgModule\Imagine\Filter\FilterManager');
        }

        return $this->filterManager;
    }

    /**
     * Gets imagine
     *
     * @return \Imagine\Image\ImagineInterface
     */
    public function getImagine()
    {
        if (!$this->imagine) {
            $this->imagine = $this->getServiceLocator()->get('HtImg\Imagine');
        }

        return $this->imagine;
    }

    /**
     * Gets cacheManager
     *
     * @return \HtProfileImage\Service\CacheManager
     */
    public function getCacheManager()
    {
        if (!$this->cacheManager) {
            $this->cacheManager = $this->getServiceLocator()->get('HtProfileImage\Service\CacheManager');
        }

        return $this->cacheManager;
    }
}
