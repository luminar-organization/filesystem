<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\Models\Directory;
use Luminar\FileSystem\Models\File;

class DirectoryManager
{
    /**
     * @param string $path
     * @param int $permissions
     * @param bool $recursive
     * @return Directory
     * @throws FileManagerException
     */
    public function createDirectory(string $path, int $permissions = 0755, bool $recursive = true): Directory
    {
        if(!mkdir($path, $permissions, $recursive) && !$this->directoryExists($path)) {
            throw new FileManagerException("Failed to create directory $path");
        }

        return new Directory($path);
    }

    /**
     * @param string $path
     * @return array
     */
    public function scan(string $path): array
    {
        $files = scandir($path);
        $response = [];
        foreach($files as $file) {
            if(is_dir($path . $file)) {
                $response[$file] = new Directory($file);
            } else {
                $response[$file] = new File($file);
            }
        }

        return $response;
    }

    /**
     * @param string $path
     * @return Directory
     * @throws FileManagerException
     */
    public function get(string $path): Directory
    {
        if(!$this->directoryExists($path)) {
            throw new FileManagerException("Directory $path does not exist");
        }
        return new Directory($path);
    }

    /**
     * @param string $directory
     * @return bool
     */
    public function directoryExists(string $directory): bool
    {
        return is_dir($directory);
    }

}