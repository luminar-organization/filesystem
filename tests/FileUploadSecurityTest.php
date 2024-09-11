<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileUploadSecurityException;
use Luminar\FileSystem\FileUploadSecurity;
use PHPUnit\Framework\TestCase;

class FileUploadSecurityTest extends TestCase
{
    /**
     * @return void
     * @throws FileUploadSecurityException
     */
    public function testValidation()
    {
        $fileUploadSecurity = new FileUploadSecurity(['text/plain'], 2 * 1024 * 1024);

        // Valid File
        $this->assertTrue($fileUploadSecurity->validateFile(__DIR__ . '/fixtures/valid.txt'));

        // Invalid file
        $this->expectException(FileUploadSecurityException::class);
        $this->expectExceptionMessage("Invalid file type: " . mime_content_type(__DIR__ . '/fixtures/invalid.jpg'));
        $fileUploadSecurity->validateFile(__DIR__ . '/fixtures/invalid.jpg');
    }

    public function testSanitization()
    {
        // Algorithm will remove all characters that are not in basic ASCII table or have some directory separators like "\", "/" or other special characters
        $pureText = "witaj_wiecie";
        $text = "witaj_świecie";

        $fileUploadSecurity = new FileUploadSecurity(['text/plain'], 2 * 1024 * 1024);

        $this->assertEquals($pureText, $fileUploadSecurity->sanitizeName($text));
    }
}