<?php

namespace Didslm\FileUploadWrapper\Tests\unit;

use Didslm\FileUploadWrapper\exception\MissingFileException;
use Didslm\FileUploadWrapper\File;
use Didslm\FileUploadWrapper\checker\FileType;
use Didslm\FileUploadWrapper\tests\unit\entity\Product;
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

    public function testShouldUploadJpegFileSuccessfully()
    {

        $product = new Product();

        $_FILES['article_image'] = [
            'name' => 'testimg.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/test.jpg',
            'error' => 0,
            'size' => 123456
        ];

        exec('"test" > /tmp/test.jpg');


        File::upload($product, [
            new FileType([Type::JPEG])
        ]);

        $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/public/images/';

        self::assertFileExists($fileDir . $product->getImageFilename());
        exec('rm -r '.dirname($fileDir . $product->getImageFilename()));
        self::assertFileDoesNotExist($fileDir. $product->getImageFilename());
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
}