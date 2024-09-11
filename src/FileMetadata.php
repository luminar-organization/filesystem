<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileMetadataException;

class FileMetadata
{
    /**
     * @param string $path
     * @return array
     * @throws FileMetadataException
     */
    public function get(string $path): array
    {
        if(!file_exists($path)) {
            throw new FileMetadataException("File does not exist");
        }

        return [
            'basename' => basename($path),
            'size' => filesize($path),
            'is_readable' => is_readable($path),
            'is_writable' => is_writable($path),
            'is_executable' => is_executable($path),
            'type' => filetype($path),
            'owner' => fileowner($path),
            'group' => filegroup($path),
            'permissions' => substr(sprintf('%o', fileperms($path)), -4),
            'last_access_time' => fileatime($path),
            'last_modified_time' => filemtime($path),
            'creation_time' => filectime($path),
        ];
    }

    /**
     * @param string $path
     * @param int $permissions
     * @return void
     * @throws FileMetadataException
     */
    public function updatePermissions(string $path, int $permissions): void
    {
        if(!file_exists($path)) {
            throw new FileMetadataException("File does not exist");
        }

        if(!chmod($path, $permissions)) {
            throw new FileMetadataException("Permissions cannot be changed");
        }
    }

    /**
     * @param string $path
     * @param int $owner
     * @param int $group
     * @return void
     * @throws FileMetadataException
     */
    public function updateOwnerAndGroup(string $path, int $owner, int $group): void
    {
        if(!file_exists($path)) {
            throw new FileMetadataException("File does not exist");
        }

        if(!chown($path, $owner)) {
            throw new FileMetadataException("Owner cannot be changed");
        }

        if(!chgrp($path, $group)) {
            throw new FileMetadataException("Group cannot be changed");
        }
    }

    /**
     * @param string $path
     * @param string $type
     * @return bool
     * @throws FileMetadataException
     */
    public function isMimeType(string $path, string $type): bool
    {
        if(!file_exists($path)) {
            throw new FileMetadataException("File does not exist");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $path);
        finfo_close($finfo);

        return $mimeType === $type;
    }
}