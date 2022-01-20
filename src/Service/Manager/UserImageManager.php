<?php

namespace App\Service\Manager;

use App\Entity\UserImage;
use App\Service\File\FileSystem\FileSystemWorker;
use App\Service\File\ImageResizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserImageManager
{
    public function __construct(
        public EntityManagerInterface $entityManager,
        public FileSystemWorker       $systemWorker,
        public ContainerInterface     $container,
        public ImageResizer           $imageResizer
    )
    {
    }

    /**
     * @param string $userDir
     * @param string|null $tempImageFileName
     * @return UserImage|null
     */
    public function saveImageForUser(string $userDir, string $tempImageFileName = null)
    {
        $uploadsTempDir = $this->container->getParameter('uploads_temp_dir');
        if (!$tempImageFileName) {
            return null;
        }
        $this->systemWorker->createFolderIfNotExist($userDir);
        $fileNameId = uniqid();
        $imageSmallParam = [
            'width' => 60,
            'height' => null,
            'newFolder' => $userDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'small')
        ];
        $imageMiddleParam = [
            'width' => 430,
            'height' => null,
            'newFolder' => $userDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'middle')
        ];
        $imageBigParam = [
            'width' => 800,
            'height' => null,
            'newFolder' => $userDir,
            'newFileName' => sprintf('%s_%s.jpeg', $fileNameId, 'big')
        ];
        $imageSmall = $this->imageResizer->resizeImageAndSave($uploadsTempDir, $tempImageFileName, $imageSmallParam);
        $imageMiddle = $this->imageResizer->resizeImageAndSave($uploadsTempDir, $tempImageFileName, $imageMiddleParam);;
        $imageBig = $this->imageResizer->resizeImageAndSave($uploadsTempDir, $tempImageFileName, $imageBigParam);;
        $userImage = new UserImage();
        $userImage->setFileNameSmall($imageSmall);
        $userImage->setFileNameMiddle($imageMiddle);
        $userImage->setFileNameBig($imageBig);
        return $userImage;
    }

    public function removeImageFromUser(UserImage $userImage, string $userImageDir)
    {
        $smallFilePath = $userImageDir . '/' . $userImage->getFileNameSmall();
        $this->systemWorker->remove($smallFilePath);
        $middleFilePath = $userImageDir . '/' . $userImage->getFileNameMiddle();
        $this->systemWorker->remove($middleFilePath);
        $bigFilePath = $userImageDir . '/' . $userImage->getFileNameBig();
        $this->systemWorker->remove($bigFilePath);
        $user = $userImage->getUser();
        $user->removeUserImage($userImage);
        $this->entityManager->flush();
    }
}