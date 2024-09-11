<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileManager;
use Luminar\FileSystem\Models\File;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testGet()
    {
        $fileManager = new FileManager();
        $file = $fileManager->get(__DIR__ . '/fixtures/file.txt');
        $this->assertInstanceOf(File::class, $file);
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testCreateAndExist()
    {
        $fileManager = new FileManager();
        $newFile = $fileManager->create(__DIR__ . '/fixtures/new_file.txt', "New File");
        $this->assertInstanceOf(File::class, $newFile);
        $this->assertTrue($fileManager->exists($newFile->getPath()));
        $newFile->remove();
    }
}