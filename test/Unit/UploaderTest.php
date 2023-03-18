<?php

namespace Didslm\FileUpload\Test\Unit;

use Didslm\FileUpload\Attribute\Image;
use Didslm\FileUpload\Attribute\Video;
use Didslm\FileUpload\Exception\MissingFileException;
use Didslm\FileUpload\Uploader as File;
use Didslm\FileUpload\Validation\FileSize;
use PHPUnit\Framework\TestCase;

class UploaderTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        $this->dir = dirname(__DIR__, 2) . '/uploads/';
        parent::setUp();
        $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 2);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_FILES = [];
        exec('rm -rf ' . $this->dir);
    }

    public function testShouldThrowExceptionWhenMoreThanOneAttributeIsDefined(): void
    {
        $obj = new class() {

            #[Image('image', 'uploads')]
            #[Video('image', dir: 'uploads')]
            private string $image;

        };

        $_FILES = [
            'image' => [
                'name' => 'test.png',
                'type' => 'image/png',
                'tmp_name' => tempnam(sys_get_temp_dir(), 'test_'),
                'error' => 0,
                'size' => 12345
            ],
        ];

        $this->expectException(\Didslm\FileUpload\Exception\TooManyAttributesException::class);
        $this->expectExceptionMessage('Too many attributes defined for field: image');

        File::upload($obj, [
           new FileSize(10) //this will test all the uploaded files and fail if one of them is bigger than 5MB
        ]);
    }

    
}
