<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileLockManager;
use PHPUnit\Framework\TestCase;

class FileLockManagerTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testLock()
    {
        $fileLockManager = new FileLockManager();
        $fileLockManager->acquireLock(__DIR__ . '/fixtures/example.lock');
        $this->assertTrue($fileLockManager->isLocked());
        $fileLockManager->releaseLock();
        $this->assertFalse($fileLockManager->isLocked());
    }
}