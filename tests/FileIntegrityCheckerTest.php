<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileIntegrityChecker;
use PHPUnit\Framework\TestCase;

class FileIntegrityCheckerTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testCalculateChecksum()
    {
        $fileIntegrityChecker = new FileIntegrityChecker();
        $checksum = $fileIntegrityChecker->calcChecksum(__DIR__ . '/fixtures/example.file');
        $this->assertNotNull($checksum);
    }

    /**
     * @return void
     * @throws FileManagerException
     */
    public function testChecksumVerification()
    {
        $fileIntegrityChecker = new FileIntegrityChecker();
        $secondChecksum = $fileIntegrityChecker->calcChecksum(__DIR__ . '/fixtures/file.txt');
        $this->assertFalse($fileIntegrityChecker->verifyChecksum(__DIR__ . '/fixtures/valid.txt', $secondChecksum));
    }
}