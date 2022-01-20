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
        public SluggerInterface $slugger,
        public ContainerInterface $serviceContainer,
        public FileSystemWorker $fileSystemWorker
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

}