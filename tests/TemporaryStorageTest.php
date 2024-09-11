<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\TemporaryFileManager;
use PHPUnit\Framework\TestCase;

class TemporaryStorageTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testTempStorage()
    {
        $temp = new TemporaryFileManager(__DIR__ . '/fixtures/tmp');
        $file = $temp->createTempFile();
        $file->write("Hello World");
        $this->assertEquals("Hello World", $file->read());
        sleep(1);
        $temp->clean(0);
        $this->assertFalse($file->exists());
    }
}