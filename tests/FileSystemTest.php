<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileSystem;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{
    /**
     * @return void
     */
    public function testExists()
    {
        $fileSystem = new FileSystem();
        $this->assertTrue($fileSystem->exists(__DIR__ . '/fixtures/file.txt'));
        $this->assertFalse($fileSystem->exists(__DIR__ . '/fixtures/invalid.txt'));
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testCopyAndDelete()
    {
        $fileSystem = new FileSystem();
        $fileSystem->copy(__DIR__ . '/fixtures/file.txt', __DIR__ . '/fixtures/copy.txt');
        $this->assertTrue($fileSystem->exists(__DIR__ . '/fixtures/copy.txt'), error_get_last());
        $fileSystem->delete(__DIR__ . '/fixtures/copy.txt');
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testMove()
    {
        $fileSystem = new FileSystem();
        $fileSystem->move(__DIR__ . '/fixtures/file.txt', __DIR__ . '/fixtures/new.txt');
        $this->assertTrue($fileSystem->exists(__DIR__ . '/fixtures/new.txt'));
        $fileSystem->move(__DIR__ . '/fixtures/new.txt', __DIR__ . '/fixtures/file.txt');
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testRead()
    {
        $fileSystem = new FileSystem();
        $this->assertEquals("Hello World", $fileSystem->read(__DIR__ . '/fixtures/read.txt'));
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testWrite()
    {
        $fileSystem = new FileSystem();
        $fileSystem->write(__DIR__ . '/fixtures/write.txt', "Hello PHP");
        $this->assertEquals("Hello PHP", $fileSystem->read(__DIR__ . '/fixtures/write.txt'));
    }
}