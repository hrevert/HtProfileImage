<?php
namespace HtProfileImage\Service;

use ZfcUser\Entity\UserInterface;
use Imagine\Image\ImageInterface;
use HtImgModule\Service\CacheManagerInterface as HtImgCacheManagerInterface;
use HtProfileImage\Model\StorageModelInterface;

class CacheManager implements CacheManagerInterface
{
    /**
     * @var HtImgCacheManagerInterface
     */
    protected $cacheManager;

    /**
     * @var StorageModelInterface
     */
    protected $storageModel;

    /**
     * Constructor
     *
     * @param HtImgCacheManagerInterface $cacheManager
     * @param StorageModelInterface      $storageModel
     */
    public function __construct(HtImgCacheManagerInterface $cacheManager, StorageModelInterface $storageModel)
    {
        $this->cacheManager = $cacheManager;
        $this->storageModel = $storageModel;
    }

    /**
     * {@inheritDoc}
     */
    public function cacheExists(UserInterface $user, $filter)
    {
        return $this->cacheManager->cacheExists(
            'user/' . $user->getId(),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheUrl(UserInterface $user, $filter)
    {
        return $this->cacheManager->getCacheUrl(
            'user/' . $user->getId(),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCachePath(UserInterface $user, $filter)
    {
        return $this->cacheManager->getCachePath(
            'user/' . $user->getId(),
            $filter,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createCache(UserInterface $user, $filter, ImageInterface $image)
    {
        $this->cacheManager->createCache(
            'user/' . $user->getId(),
            $filter,
            $image,
            $this->storageModel->getUserImageExtension()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function deleteCache(UserInterface $user, $filter)
    {
        $cachePath = $this->getCachePath($user, $filter);

        return is_readable($cachePath) ? unlink($cachePath) : false;
    }
}
