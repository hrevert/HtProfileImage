<?php

namespace HtProfileImage\Model;

use HtProfileImage\Options\StorageOptionsInterface;

class StorageResizerProvider
{
    /**
     * @var StorageOptionsInterface
     */
    protected $storageOptions;

    /**
     * Constructor
     *
     * @param $storageOptions StorageOptionsInterface
     * @return void
     */
    public function __construct(StorageOptionsInterface $storageOptions)
    {
        $this->storageOptions = $storageOptions;
    }

    /**
     * gets StorageOptionsInterface
     * @return StorageOptionsInterface
     */
    public function getStorageOptions()
    {
        return $this->storageOptions;
    }

    /**
     * gets resizer for storing
     */
    public function getStorageResizer()
    {
        if ($this->getStorageOptions()->getStorageResizer()) {
            $resizingOptions = $this->getStorageOptions()->getStorageResizer();
            $resizer = new $resizingOptions['name'];
            $resizer->setOptions($resizingOptions['options']);  
            return $resizer;
        }
        $size = $this->getStorageOptions()->getStoredImageSize();
        if ($size === null) {
            return false;
        }
        $resizer = new \HCommons\Image\AdaptiveResizing();
        $resizer->setWidth($size);
        $resizer->setHeight($size);

        return $resizer;
    }
}
