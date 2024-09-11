<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;

class FileLockManager
{
    /**
     * @var mixed $fileHandle
     */
    protected mixed $fileHandle;

    /**
     * @param string $path
     * @param bool $exclusive
     * @return true
     * @throws FileManagerException
     */
    public function acquireLock(string $path, bool $exclusive = true): true
    {
        if(!file_exists($path)) {
            throw new FileManagerException("File does not exist!");
        }

        $this->fileHandle = fopen($path, "c");
        if($this->fileHandle === false) {
            throw new FileManagerException("Failed to open lock file!");
        }

        $lockType = $exclusive ? LOCK_EX : LOCK_SH;
        if(!flock($this->fileHandle, $lockType)) {
            fclose($this->fileHandle);
            throw new FileManagerException("Failed to acquire lock!");
        }

        return true;
    }

    /**
     * @return true
     * @throws FileManagerException
     */
    public function releaseLock(): true
    {
        if($this->fileHandle === null) {
            throw new FileManagerException("No file is currently locked!");
        }

        if(!flock($this->fileHandle, LOCK_UN)) {
            throw new FileManagerException("Failed to release lock on file.");
        }

        fclose($this->fileHandle);
        $this->fileHandle = null;

        return true;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->fileHandle !== null;
    }
}