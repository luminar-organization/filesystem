<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileCompressException;
use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileCompressor;
use Luminar\FileSystem\Models\File;
use PHPUnit\Framework\TestCase;

class FileCompressTest extends TestCase
{
    /**
     * @return void
     * @throws FileCompressException
     * @throws FileManagerException
     */
    public function testCompress()
    {
        $fileCompressor = new FileCompressor();
        $compressedFile = $fileCompressor->compress(__DIR__ . '/fixtures/file.txt', __DIR__ . '/fixtures/compressed.zip');
        $this->assertInstanceOf(File::class, $compressedFile);
        $decompressedFile = $fileCompressor->decompress($compressedFile->getPath(), __DIR__ . '/fixtures/decompressed.txt');
        $this->assertInstanceOf(File::class, $decompressedFile);
        $compressedFile->remove();
        $decompressedFile->remove();
    }
}