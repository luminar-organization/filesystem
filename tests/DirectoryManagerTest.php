<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\DirectoryManager;
use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\Models\Directory;
use PHPUnit\Framework\TestCase;

class DirectoryManagerTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testDirectoryManager()
    {
        $directoryManager = new DirectoryManager();
        $dir = $directoryManager->createDirectory(__DIR__ . '/fixtures/example');
        $this->assertInstanceOf(Directory::class, $dir);
        $this->assertTrue($dir->exists());
        $dir = $directoryManager->get(__DIR__ . '/fixtures/example');
        $this->assertInstanceOf(Directory::class, $dir);
        $this->assertTrue($dir->exists());
        $this->assertTrue($directoryManager->directoryExists(__DIR__ . '/fixtures/example'));
        $dir->delete();
        $this->assertFalse($directoryManager->directoryExists(__DIR__ . '/fixtures/example'));
    }
}