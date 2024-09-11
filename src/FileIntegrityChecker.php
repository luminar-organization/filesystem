<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\Models\File;

class FileIntegrityChecker
{
    /**
     * @param string $path
     * @param string $algorithm
     * @return string
     * @throws FileManagerException
     */
    public function calcChecksum(string $path, string $algorithm = 'sha256'): string
    {
        if(!file_exists($path)) {
            throw new FileManagerException("File does not exist");
        }

        if(!in_array($algorithm, hash_algos())) {
            throw new FileManagerException("Unknown algorithm");
        }

        $hash = hash_file($algorithm, $path);

        if($hash === false) {
            throw new FileManagerException("Failed to calculate checksum for file");
        }

        return $hash;
    }

    /**
     * @param string $path
     * @param string $checksum
     * @param string $algorithm
     * @return bool
     * @throws FileManagerException
     */
    public function verifyChecksum(string $path, string $checksum, string $algorithm = 'sha256'): bool
    {
        $realChecksum = $this->calcChecksum($path, $algorithm);
        return hash_equals($realChecksum, $checksum);
    }

    /**
     * @param string $path
     * @param string $algorithm
     * @return File
     * @throws FileManagerException
     */
    public function generateChecksumFile(string $path, string $algorithm = 'sha256'): File
    {
        $checksum = $this->calcChecksum($path, $algorithm);
        $checksumFilePath = $path . '.' . $algorithm . '.checksum';

        if(file_put_contents($checksumFilePath, $checksum) === false) {
            throw new FileManagerException("Failed to write checksum file");
        }

        return new File($checksumFilePath);
    }

    /**
     * @param string $path
     * @param string $checksumFile
     * @param string $algorithm
     * @return bool
     * @throws FileManagerException
     */
    public function validateAgainstChecksumFile(string $path, string $checksumFile, string $algorithm = 'sha256'): bool
    {
        if(!file_exists($path)) {
            throw new FileManagerException("File does not exist");
        }

        $realChecksum = trim(file_get_contents($checksumFile));
        return $this->verifyChecksum($path, $realChecksum, $algorithm);
    }
}