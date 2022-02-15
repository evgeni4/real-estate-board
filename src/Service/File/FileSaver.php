<?php

namespace App\Service\File;


use App\Service\File\FileSystem\FileSystemWorker;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileSaver
{
    private string $uploads_temp_dir;

    public function __construct(
        public SluggerInterface   $slugger,
        public ContainerInterface $serviceContainer,
        public FileSystemWorker   $fileSystemWorker
    )
    {
    }

    public function saveUploadedFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $uploadsTempDir = $this->serviceContainer->getParameter('uploads_temp_dir');
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileName = $this->slugger->slug($originalFileName);
        $fileName = sprintf('%s-%s.%s', $saveFileName, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadsTempDir);
        try {
            $uploadedFile->move($uploadsTempDir, $fileName);
        } catch (\Exception $exception) {
            return null;
        }
        return $fileName;
    }

    public function saveUploadedCoverFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $uploadsCoverTempDir = $this->serviceContainer->getParameter('uploads_temp_dir');
        $originalFileNameCover = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileNameCover = $this->slugger->slug($originalFileNameCover);
        $fileNameCover = sprintf('%s-%s.%s', $saveFileNameCover, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadsCoverTempDir);
        try {
            $uploadedFile->move($uploadsCoverTempDir, $fileNameCover);
        } catch (\Exception $exception) {
            return null;
        }
        return $fileNameCover;
    }

    public function saveUploadedPropertyFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $uploadTempDir = $this->serviceContainer->getParameter('uploads_property_temp_dir');
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileName = $this->slugger->slug($originalFileName);
        $fileName = sprintf('%s-%s.%s', $saveFileName, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadTempDir);
        try {
            $uploadedFile->move($uploadTempDir, $fileName);
        } catch (\Exception $exception) {
            return null;
        }

        return $fileName;
    }

    public function saveUploadedPropertyWidgetFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $uploadWidgetTempDir = $this->serviceContainer->getParameter('uploads_property_widget_temp_dir');
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileName = $this->slugger->slug($originalFileName);
        $fileName = sprintf('%s-%s.%s', $saveFileName, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadWidgetTempDir);
        try {
            $uploadedFile->move($uploadWidgetTempDir, $fileName);
        } catch (\Exception $exception) {
            return null;
        }

        return $fileName;
    }

    public function saveUploadedPropertyPlanFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $uploadWidgetTempDir = $this->serviceContainer->getParameter('uploads_property_plan_temp_dir');
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileName = $this->slugger->slug($originalFileName);
        $fileName = sprintf('%s-%s.%s', $saveFileName, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadWidgetTempDir);
        try {
            $uploadedFile->move($uploadWidgetTempDir, $fileName);
        } catch (\Exception $exception) {
            return null;
        }

        return $fileName;
    }

    public function saveLogoUploadedFileIntoTemp(UploadedFile $uploadedFile)
    {
        $uploadedTempDir = $this->serviceContainer->getParameter('logo_image_temp_dir');
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFileName = $this->slugger->slug($originalFileName);
        $fileName = sprintf('%s-%s.%s', $saveFileName, uniqid(), $uploadedFile->guessExtension());
        $this->fileSystemWorker->createFolderIfNotExist($uploadedTempDir);
        try {
            $uploadedFile->move($uploadedTempDir,$fileName);
        }catch (\Exception $exception){
            return null;
        }
        return $fileName;
    }

}