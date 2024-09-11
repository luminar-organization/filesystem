<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileMetadataException;
use Luminar\FileSystem\FileMetadata;
use PHPUnit\Framework\TestCase;

class FileMetadataTest extends TestCase
{
    /**
     * @return void
     * @throws FileMetadataException
     */
    public function testGet()
    {
        $fileMetadata = new FileMetadata();
        $metadata = $fileMetadata->get(__DIR__ . '/fixtures/file.txt');
        $this->assertNotNull($metadata);
    }

    /**
     * @return void
     * @throws FileMetadataException
     */
    public function testUpdatePermissions()
    {
        $fileMetadata = new FileMetadata();
        $metadata = $fileMetadata->get(__DIR__ . '/fixtures/file.txt');
        $oldPermissions = $metadata['permissions'];

        $fileMetadata->updatePermissions(__DIR__ . '/fixtures/file.txt', 0555);

        $fileMetadata->updatePermissions(__DIR__ . '/fixtures/file.txt', $oldPermissions);
        $this->assertEquals($oldPermissions, $fileMetadata->get(__DIR__ . '/fixtures/file.txt')['permissions']);
    }

    /**
     * @return void
     * @throws FileMetadataException
     */
    public function testUpdateOwner()
    {
        $fileMetadata = new FileMetadata();
        $metadata = $fileMetadata->get(__DIR__ . '/fixtures/file.txt');
        $oldGroup = $metadata['group'];
        $oldOwner = $metadata['owner'];

        $this->expectException(FileMetadataException::class);

        $fileMetadata->updateOwnerAndGroup(__DIR__ . '/fixtures/file.txt', $oldOwner+1, $oldGroup+1);

        $this->assertNotEquals($oldGroup, $fileMetadata->get(__DIR__ . '/fixtures/file.txt')['group']);
        $this->assertNotEquals($oldOwner, $fileMetadata->get(__DIR__ . '/fixtures/file.txt')['owner']);

        $fileMetadata->updateOwnerAndGroup(__DIR__ . '/fixtures/file.txt', $oldOwner, $oldGroup);
    }

    /**
     * @return void
     * @throws FileMetadataException
     */
    public function testMimeType()
    {
        $fileMetadata = new FileMetadata();
        $this->assertTrue($fileMetadata->isMimeType(__DIR__ . '/fixtures/file.txt', 'text/plain'));
    }
}