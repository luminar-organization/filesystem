<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\Models\File;

class FileManager
{
    /**
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @param string $path
     * @param string $content
     * @return File
     */
    public function create(string $path, string $content): File
    {
        file_put_contents($path, $content);
        return new File($path);
    }

    /**
     * @param string $path
     * @return File
     * @throws FileManagerException
     */
    public function get(string $path): File
    {
        if(!file_exists($path))
        {
            throw new FileManagerException("File $path does not exist");
        }

        return new File($path);
    }
}