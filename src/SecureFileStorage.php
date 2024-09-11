<?php

namespace Luminar\FileSystem;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Random\RandomException;

class SecureFileStorage
{
    /**
     * @var string $encryptionKey
     */
    protected string $encryptionKey;

    /**
     * @param string $encryptionKey
     * @throws FileManagerException
     */
    public function __construct(string $encryptionKey)
    {
        if(empty($encryptionKey)) {
            throw new FileManagerException("Encryption key cannot be empty.");
        }

        $this->encryptionKey = $encryptionKey;
    }

    /**
     * @param string $source
     * @param string $destination
     * @return true
     * @throws FileManagerException
     * @throws RandomException
     */
    public function encryptAndStoreFile(string $source, string $destination): true
    {
        if(!file_exists($source)) {
            throw new FileManagerException("Source file does not exist: $source");
        }

        $data = file_get_contents($source);
        if($data === false) {
            throw new FileManagerException("Failed to read source file: $source");
        }

        $encryptedData = $this->encryptData($data);

        if(file_put_contents($destination, $encryptedData) === false) {
            throw new FileManagerException("Failed to store encrypted file: $destination");
        }

        return true;
    }

    /**
     * @param string $path
     * @return string
     * @throws FileManagerException
     */
    public function decryptAndRetrieveFile(string $path): string
    {
        if(!file_exists($path)) {
            throw new FileManagerException("File does not exist: $path");
        }

        $encryptedData = file_get_contents($path);
        if($encryptedData === false) {
            throw new FileManagerException("Failed to read encrypted file: $path");
        }

        return $this->decryptData($encryptedData);
    }

    /**
     * @param string $path
     * @return true
     * @throws FileManagerException
     * @throws RandomException
     */
    public function securelyDeleteFile(string $path): true
    {
        if(!file_exists($path)) {
            throw new FileManagerException("File does not exist: $path");
        }

        $fileSize = filesize($path);
        if($fileSize === false) {
            throw new FileManagerException("Failed to determine file size: $path");
        }

        $handle = fopen($path, "r+");
        if($handle === false) {
            throw new FileManagerException("Failed to open file for overwriting: $path");
        }

        $randomData = random_bytes($fileSize);
        fwrite($handle, $randomData);
        fclose($handle);

        if(!unlink($path)) {
            throw new FileManagerException("Failed to delete file securely: $path");
        }

        return true;
    }

    /**
     * @param string $data
     * @return string
     * @throws FileManagerException
     * @throws RandomException
     */
    protected function encryptData(string $data): string
    {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($data, "aes-256-cbc", $this->encryptionKey, 0, $iv);

        if($encryptedData === false) {
            throw new FileManagerException("Encryption failed.");
        }

        return base64_encode($iv . $encryptedData);
    }

    /**
     * @param string $encryptedData
     * @return string
     * @throws FileManagerException
     */
    protected function decryptData(string $encryptedData): string
    {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength);
        $cipherText = substr($data, $ivLength);

        $decryptedData = openssl_decrypt($cipherText, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        if($decryptedData === false) {
            throw new FileManagerException("Decryption failed.");
        }

        return $decryptedData;
    }
}