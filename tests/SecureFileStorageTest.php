<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\SecureFileStorage;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

class SecureFileStorageTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     * @throws RandomException
     */
    public function testEncryption()
    {
        // Generate Example OpenSSL Private Key
        $config = [
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ];
        $privateKey = openssl_pkey_new($config);
        openssl_pkey_export($privateKey, $privateKeyOutput);
        ///

        $secureFileStorage = new SecureFileStorage($privateKeyOutput);

        $secureFileStorage->encryptAndStoreFile(__DIR__ . '/fixtures/example.file', __DIR__ . '/fixtures/example.encrypted.file');

        $this->assertTrue(file_exists(__DIR__ . '/fixtures/example.encrypted.file'));

        $data = $secureFileStorage->decryptAndRetrieveFile(__DIR__ . '/fixtures/example.encrypted.file');

        $this->assertNotEquals($data, file_get_contents(__DIR__ . '/fixtures/example.encrypted.file'));
        $this->assertEquals("Hello World", $data);
        $this->assertTrue($secureFileStorage->securelyDeleteFile(__DIR__ . '/fixtures/example.encrypted.file'));
    }
}