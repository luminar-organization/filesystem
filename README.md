# File System Library

![Tests Status](https://img.shields.io/github/actions/workflow/status/luminar-organization/filesystem/tests.yml?label=Tests)

This repository contains a comprehensive PHP Luminar Framework for managing file systems securely and efficiently. The library provides various utilities for handling file operations, integrity checks, content searching, metadata management, and more.

## Overview

The repository is structured into several components, each responsible for specific file management functionalities:

- **DirectoryManager.php**: Manages directory operations, including creation, deletion, and listing.
- **FileCompressor.php**: Provides utilities for compressing and decompressing files.
- **FileContentSearcher.php**: Allows searching for text patterns within files using plain text or regular expressions.
- **FileIntegrityChecker.php**: Ensures file integrity by calculating and verifying checksums.
- **FileLockManager.php**: Manages file locks to prevent concurrent write issues.
- **FileManager.php**: Handles general file operations, such as reading, writing, copying, and deleting files.
- **FileMetadata.php**: Manages and retrieves metadata associated with files.
- **FileSystem.php**: Main entry point to the file system utilities, orchestrating various components.
- **FileUploadSecurity.php**: Provides security checks for file uploads, such as MIME type validation and size restrictions.
- **SecureFileStorage.php**: Manages secure file storage operations, including encryption and access control.
- **TemporaryFileManager.php**: Handles operations for temporary files, such as creation, management, and deletion.

## Exception Handling

The repository includes specific exception classes for error handling:

- **FileCompressException.php**: Thrown when an error occurs during file compression or decompression.
- **FileManagerException.php**: Thrown for general file management errors.
- **FileMetadataException.php**: Thrown when issues arise while handling file metadata.
- **FileUploadSecurityException.php**: Thrown for security violations during file uploads.

## Data Models

The repository utilizes several models to represent file system entities:

- **Directory.php**: Represents a directory within the file system.
- **File.php**: Represents a file within the file system.

## Installation

To install the repository, you can use Composer:

```bash
composer require luminar-organization/filesystem
```

## License

This project is licensed under the MIT License. See the [License File](LICENSE) for details

## Contributing

To contribute this repository please check out CONTRIBUTING.md