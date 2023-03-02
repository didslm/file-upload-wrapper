<?php

namespace Didslm\FileUploadWrapper\Tests\unit;

use Didslm\FileUploadWrapper\File;
use Didslm\FileUploadWrapper\checker\FileType;
use Didslm\FileUploadWrapper\checker\checker;
use Didslm\FileUploadWrapper\tests\unit\entity\Product;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    public function testShouldUploadJpegFileSuccessfully()
    {

        $rootDir = $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 2);

        $product = new Product();

        //add dummy file to $_FILES
        $_FILES['article_image'] = [
            'name' => 'testimg.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/test.jpg',
            'error' => 0,
            'size' => 123456
        ];

        exec('"test" > /tmp/test.jpg');


        File::upload($product, [
            new FileType([Checker::JPEG])
        ]);

        $fileDir = $rootDir . '/public/images/';

        self::assertFileExists($fileDir . $product->getImageFilename());
        exec('rm -r '.dirname($fileDir . $product->getImageFilename()));
        self::assertFileDoesNotExist($fileDir. $product->getImageFilename());
    }
}