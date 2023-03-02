<?php

namespace Didslm\FileUploadWrapper\Tests\unit;

use Didslm\FileUploadWrapper\File;
use Didslm\FileUploadWrapper\filters\FileType;
use Didslm\FileUploadWrapper\tests\unit\entity\Product;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    public function testShouldUploadJpegFileSuccessfully()
    {

        //get root dir
        $rootDir = dirname(__DIR__, 2);

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
            new FileType([FileType::JPEG])
        ]);


        self::assertFileExists($product->getImageFilename());
        exec('rm -r '.dirname($product->getImageFilename()));
        self::assertFileDoesNotExist($product->getImageFilename());
    }
}