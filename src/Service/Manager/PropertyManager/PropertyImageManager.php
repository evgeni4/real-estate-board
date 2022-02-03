<?php

namespace App\Service\Manager\PropertyManager;

use App\Entity\PropertyImage;
use App\Service\File\FileSystem\FileSystemWorker;
use App\Service\File\ImageResizer;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PropertyImageManager
{
    public function __construct(
        public FileSystemWorker   $systemWorker,
        public ContainerInterface $serviceContainer,
        public ImageResizer       $imageResizer
    )
    {
    }

    public function saveImageForProperty(string $propertyDir, string $tempImageFileName): PropertyImage
    {
        $uploadTempDir = $this->serviceContainer->getParameter('uploads_property_temp_dir');
        $this->systemWorker->createFolderIfNotExist($propertyDir);
        $fileNameId = uniqid();
        $imageSmallParam = [
            'width' => 120,
            'height' => null,
            'newFolder' => $propertyDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'small')
        ];
        $imageMiddleParam = [
            'width' => 392,
            'height' => null,
            'newFolder' => $propertyDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'middle')
        ];
        $imageBigParam = [
            'width' => 1200,
            'height' => null,
            'newFolder' => $propertyDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'big')
        ];
        $imageSmall = $this->imageResizer->resizeImageAndSave($uploadTempDir, $tempImageFileName, $imageSmallParam);
        $imageMiddle = $this->imageResizer->resizeImageAndSave($uploadTempDir, $tempImageFileName, $imageMiddleParam);;
        $imageBig = $this->imageResizer->resizeImageAndSave($uploadTempDir, $tempImageFileName, $imageBigParam);
        $propertyImage = new PropertyImage();
        $propertyImage->setImageSm($imageSmall);
        $propertyImage->setImageMd($imageMiddle);
        $propertyImage->setImageLg($imageBig);
        return $propertyImage;
    }
}