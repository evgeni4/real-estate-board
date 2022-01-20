<?php

namespace App\Service\File\FileSystem;

use Symfony\Component\Filesystem\Filesystem;

class FileSystemWorker
{
    public function __construct(public Filesystem $filesystem)
    {
    }

    public function createFolderIfNotExist(float|int|bool|array|string|null $folder)
    {
        if (!$this->filesystem->exists($folder)) {
            $this->filesystem->mkdir($folder);
        }
    }

    public function remove(string $item)
    {
        if ($this->filesystem->exists($item)){
            $this->filesystem->remove($item);
        }
    }
}