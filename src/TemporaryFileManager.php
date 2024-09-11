<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\Models\File;

class TemporaryFileManager
{
    /**
     * @var string $tempDir
     */
    protected string $tempDir;

    public function __construct(string $tempDir = null)
    {
        $this->tempDir = $tempDir ?: sys_get_temp_dir();
        if(!is_dir($this->tempDir) || !is_writable($this->tempDir)) {
            throw new FileManagerException("Temporary directory is not writable $this->tempDir");
        }
    }

    /**
     * @param string $prefix
     * @param string $extension
     * @return File
     * @throws FileManagerException
     */
    public function createTempFile(string $prefix = "temp_", string $extension = 'tmp'): File
    {
        $tempFilePath = tempnam($this->tempDir, $prefix);

        if($tempFilePath === false) {
            throw new FileManagerException("Failed to create a temporary file in directory: $this->tempDir");
        }

        $newFilePath = $tempFilePath . '.' . $extension;
        if(!rename($tempFilePath, $newFilePath)) {
            throw new FileManagerException("Failed to set extension for the temporary file: $newFilePath");
        }

        return new File($newFilePath);
    }

    /**
     * @param int $maxAge
     * @return int
     */
    public function clean(int $maxAge = 3600): int
    {
        $filesDeleted = 0;

        foreach(glob($this->tempDir . DIRECTORY_SEPARATOR . '*') as $file) {
            if(is_file($file) && (time() - filemtime($file) > $maxAge)) {
                if(@unlink($file)) {
                    $filesDeleted++;
                }
            }
        }

        return $filesDeleted;
    }
}