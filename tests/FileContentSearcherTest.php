<?php

namespace Luminar\FileSystem\Tests;

use Luminar\FileSystem\Exceptions\FileManagerException;
use Luminar\FileSystem\FileContentSearcher;
use PHPUnit\Framework\TestCase;

class FileContentSearcherTest extends TestCase
{
    /**
     * @return void
     * @throws FileManagerException
     */
    public function testSearch()
    {
        $fileContentSearcher = new FileContentSearcher();
        $file = $fileContentSearcher->searchString(__DIR__ . '/fixtures/search.txt', "Text To Search");
        $this->assertNotNull($file[0]);
    }
}