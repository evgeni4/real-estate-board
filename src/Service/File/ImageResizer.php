<?php

namespace App\Service\File;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageResizer
{
    private Imagine $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    /**
     * @param string $originalFileFolder
     * @param string $originalFileName
     * @param array $option
     * @return string
     */
    public function resizeImageAndSave(string $originalFileFolder, string $originalFileName, array $option): string
    {
        $originalFilePath = $originalFileFolder . '/' . $originalFileName;
        list($imageWidth, $imageHeight) = getimagesize($originalFilePath);
        $ratio = $imageWidth / $imageHeight;
        $targetWidth = $option['width'];
        $targetHeight = $option['height'];
        if ($targetHeight) {
            if ($targetWidth / $targetHeight > $ratio) {
                $targetWidth = $targetHeight * $ratio;
            } else {
                $targetHeight = $targetWidth / $ratio;
            }
        } else {
            $targetHeight = $targetWidth / $ratio;
        }
        $targetFolder = $option['newFolder'];
        $targetFileName = $option['newFileName'];
        $targetFilePath = sprintf('%s/%s', $targetFolder, $targetFileName);
        $imagineFile = $this->imagine->open($originalFilePath);
        $imagineFile->resize(
            new Box($targetWidth, $targetHeight)
        )->save($targetFilePath);
        return $targetFileName;
    }
}