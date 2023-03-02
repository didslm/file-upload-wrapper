<?php

namespace Didslm\FileUploadWrapper\Tests\unit;

use Didslm\FileUploadWrapper\exception\MissingFileException;
use Didslm\FileUploadWrapper\File;
use Didslm\FileUploadWrapper\checker\FileType;
use Didslm\FileUploadWrapper\tests\unit\entity\Product;
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
            new FileType([Type::JPEG])
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

    private function uploadFile(string $string)
    {
        $_FILES[$string] = [
            'name' => $string.'_testimg.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/test'.$string.'.jpg',
            'error' => 0,
            'size' => 123456
        ];

        exec('"test" > /tmp/test'.$string.'.jpg');

    }
}
