<?php

namespace Didslm\FileUploadWrapper\Tests\unit;

use Didslm\FileUploadWrapper\checker\CheckUploadException;
use Didslm\FileUploadWrapper\checker\FileSize;
use Didslm\FileUploadWrapper\exception\FileUploadException;
use Didslm\FileUploadWrapper\exception\MissingFileException;
use Didslm\FileUploadWrapper\File;
use Didslm\FileUploadWrapper\checker\FileType;
use Didslm\FileUploadWrapper\Size;
use Didslm\FileUploadWrapper\Tests\unit\entity\Product;
use Didslm\FileUploadWrapper\Tests\unit\entity\Profile;
use Didslm\FileUploadWrapper\Type;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $_FILES = [];
        $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 2);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $_FILES = [];

        $fileDir = dirname(__DIR__, 2) . '/public';
        exec("rm -rf $fileDir");
    }

    public function testShouldUploadJpegFileSuccessfully()
    {

        $this->uploadFile('article_image');

        $product = new Product();

        File::upload($product, [
            new FileType([Type::JPEG]),
            new FileSize(4, Size::MB)
        ]);

        $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/public/images/';

        self::assertFileExists($fileDir . $product->getImageFilename());
    }

    public function testShouldThrowExceptionWhenRequiredFileIsMissing()
    {
        $product = new Product();

        $this->expectException(MissingFileException::class);
        $this->expectExceptionMessage('Missing required file.');

        File::upload($product, [
            new FileType([Type::JPEG])
        ]);
    }

    public function testShouldUploadSuccessfullyMultipleImages()
    {
        $this->uploadFile('image');
        $this->uploadFile('cover');

        $profile = new Profile();

        File::upload($profile, [
            new FileType([Type::JPEG])
        ]);

        self::assertFileExists($_SERVER['DOCUMENT_ROOT'] . '/public/images/' . $profile->getImageFilename());
        self::assertFileExists($_SERVER['DOCUMENT_ROOT'] . '/public/images/' . $profile->getImage2Filename());
    }

    public function testShouldFailToUploadBiggerFileSize()
    {
        $this->uploadFile('article_image');

        $product = new Product();

        $this->expectException(CheckUploadException::class);
        $this->expectExceptionMessage('File size is too big. Limit is 2 MB.');

        File::upload($product, [
            new FileType([Type::JPEG]),
            new FileSize(2, Size::MB)
        ]);
    }

    public function testExceptionHandling()
    {
        $this->uploadFile('article_image');

        $product = new Product();

        try {
            File::upload($product, [
                new FileType([Type::PNG]),
                new FileSize(2, Size::MB)
            ]);
        } catch (FileUploadException $e) {
            //this will tell us that we can catch the exception
            self::assertTrue(true);
        }
    }

    private function uploadFile(string $string)
    {
        $_FILES[$string] = [
            'name' => $string.'_testimg.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/test'.$string.'.jpg',
            'error' => 0,
            'size' => 1024*3
        ];

        exec('"test" > /tmp/test'.$string.'.jpg');

    }
}
