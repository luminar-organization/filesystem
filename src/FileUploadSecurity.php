<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileUploadSecurityException;
use Luminar\FileSystem\Models\File;

class FileUploadSecurity
{
    /**
     * @var array $allowedMineTypes
     */
    protected array $allowedMineTypes = [];

    /**
     * @var int|float $maxFileSize
     */
    protected int|float $maxFileSize = 2 * 1024 * 1024;

    public function __construct(array $allowedMineTypes, int|float $maxFileSize)
    {
        $this->allowedMineTypes = $allowedMineTypes;
        $this->maxFileSize = $maxFileSize;
    }

    /**
     * @param string $filePath
     * @return true
     * @throws FileUploadSecurityException
     */
    public function validateFile(string $filePath): true
    {
        $fileMimeType = mime_content_type($filePath);

        if(!in_array($fileMimeType, $this->allowedMineTypes)) {
            throw new FileUploadSecurityException("Invalid file type: $fileMimeType");
        }

        $fileSize = filesize($filePath);

        if($fileSize > $this->maxFileSize) {
            throw new FileUploadSecurityException("File size exceeds the maximum allowed size of $this->maxFileSize");
        }

        return true;
    }

    /**
     * @param string $filePath
     * @return File
     * @throws FileUploadSecurityException
     */
    public function safeUpload(string $filePath): File
    {
        $this->validateFile($filePath);
        $sanitizedName = $this->sanitizeName($filePath);

        $destination = rtrim($sanitizedName, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . uniqid() . '_' . $sanitizedName;

        if(!move_uploaded_file($filePath, $destination)) {
            throw new FileUploadSecurityException("Failed to store the file securely.");
        }

        return new File($destination);
    }

    /**
     * @param string $name
     * @return string
     */
    public function sanitizeName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9\-_.]/', '', basename($name));
    }
}
