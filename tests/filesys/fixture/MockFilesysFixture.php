<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\filesys\fixture;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamContent;
use org\bovigo\vfs\vfsStreamDirectory;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;

/**
 * Class MockFilesysFixture.  This object can be used as a fixture for any tests that need a mocked file system.
 */
class MockFilesysFixture
{
    protected vfsStreamDirectory $vfsStreamDirectory;
    protected string $vfsRoot;
    protected array $allFilesFixture;
    protected array $phpFilesFixture;
    protected array $jsFilesFixture;
    protected array $cssCsvFilesFixture;
    protected array $filesContainingTheWordThisFixture;

    public function __construct()
    {
        $arrSrcFiles = [
            'Subdir_1' => [
                'AbstractFactory' => [
                    'test.php' => 'some text content',
                    'other.php' => 'Some more text content',
                    'Invalid.csv' => 'Something else',
                    'valid.css' => 'not real css'
                ],
                'AnEmptyFolder' => [],
                'somecode.php' => 'some php content',
                'somejavascript.js' => 'this is not real javascript - it is just a test'
            ],
            'Subdir_2' => [
                'SmallLibrary' => [
                    'libFile_1.php' => 'This is another php file of some kind',
                    'libFile_2.php' => 'This is the second php file in this library.',
                    'libFile.css' => 'This is the first css file in this library.',
                    'libFile.js' => 'This is the first javascript file in this library.',
                    'libFileDoc.txt' => 'This should be some documentation kind of stuff.',
                    'OtherJSFile.js' => 'more bogus javascript',
                    'libFile_3.php' => 'libFile_3.php content',
                    'libFile_4.php' => 'libFile_4.php content'
                ]
            ],
            'fileInRootOfFixture.ini' => 'Maybe this is some kind of a configuration file... or not'
        ];

        $this->allFilesFixture = [
            'vfs://root/Subdir_1/AbstractFactory/test.php',
            'vfs://root/Subdir_1/AbstractFactory/other.php',
            'vfs://root/Subdir_1/AbstractFactory/Invalid.csv',
            'vfs://root/Subdir_1/AbstractFactory/valid.css',
            'vfs://root/Subdir_1/somecode.php',
            'vfs://root/Subdir_1/somejavascript.js',
            'vfs://root/Subdir_2/SmallLibrary/libFile_1.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_2.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile.css',
            'vfs://root/Subdir_2/SmallLibrary/libFile.js',
            'vfs://root/Subdir_2/SmallLibrary/libFileDoc.txt',
            'vfs://root/Subdir_2/SmallLibrary/OtherJSFile.js',
            'vfs://root/Subdir_2/SmallLibrary/libFile_3.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_4.php',
            'vfs://root/fileInRootOfFixture.ini'
        ];

        $this->phpFilesFixture = [
            'vfs://root/Subdir_1/AbstractFactory/test.php',
            'vfs://root/Subdir_1/AbstractFactory/other.php',
            'vfs://root/Subdir_1/somecode.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_1.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_2.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_3.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_4.php'
        ];

        $this->jsFilesFixture = [
            'vfs://root/Subdir_1/somejavascript.js',
            'vfs://root/Subdir_2/SmallLibrary/libFile.js',
            'vfs://root/Subdir_2/SmallLibrary/OtherJSFile.js'
        ];

        $this->cssCsvFilesFixture = [
            'vfs://root/Subdir_1/AbstractFactory/Invalid.csv',
            'vfs://root/Subdir_1/AbstractFactory/valid.css',
            'vfs://root/Subdir_2/SmallLibrary/libFile.css'
        ];

        $this->filesContainingTheWordThisFixture = [
            'vfs://root/Subdir_1/somejavascript.js',
            'vfs://root/Subdir_2/SmallLibrary/libFile_1.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile_2.php',
            'vfs://root/Subdir_2/SmallLibrary/libFile.css',
            'vfs://root/Subdir_2/SmallLibrary/libFile.js',
            'vfs://root/Subdir_2/SmallLibrary/libFileDoc.txt',
            'vfs://root/fileInRootOfFixture.ini'
        ];

        $filesysRoot = 'root';
        $permissions = null;
        $this->vfsStreamDirectory = vfsStream::setup($filesysRoot, $permissions, $arrSrcFiles);
        $this->vfsRoot = $this->vfsStreamDirectory->url();
    }

    /**
     * @function findVfsFiles
     * @param vfsStreamContent $vfsStreamContent
     * @param string $regex
     * @return array
     * @throws InvalidArgumentException
     */
    public function findVfsFiles(vfsStreamContent $vfsStreamContent, string $regex): array
    {
        $files = [];

        if (($vfsStreamContent->getType() == vfsStreamContent::TYPE_FILE) &&
            (preg_match($regex, $vfsStreamContent->url()))) {
            $files[] = $vfsStreamContent->url();
            return $files;
        }

        if ($vfsStreamContent instanceof vfsStreamDirectory) {
            $childIterator = $vfsStreamContent->getChildren();
            foreach ($childIterator as $file) {
                if (($file instanceof vfsStreamDirectory) && !$file->isDot()) {
                    $files = array_merge($files, $this->findVfsFiles($file, $regex));
                } elseif (preg_match($regex, $file->url())) {
                    $files[] = $file->url();
                }
            }
        }
        return $files;
    }

    public function getVfsStreamDirectory(): vfsStreamDirectory
    {
        return $this->vfsStreamDirectory;
    }

    public function getVfsRoot(): string
    {
        return $this->vfsRoot;
    }

    public function changePermissionsOnRootToUnreadable() : void
    {
        $this->getVfsStreamDirectory()->chmod(0000);
    }

    public function getAllFilesFixture(): array
    {
        return $this->allFilesFixture;
    }

    public function getPhpFilesFixture(): array
    {
        return $this->phpFilesFixture;
    }

    public function getJsFilesFixture(): array
    {
        return $this->jsFilesFixture;
    }

    public function getCssCsvFilesFixture(): array
    {
        return $this->cssCsvFilesFixture;
    }

    public function getFilesContainingTheWordThisFixture(): array
    {
        return $this->filesContainingTheWordThisFixture;
    }
}
