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

    public function testUploadMultipleFiles(): void
    {
        $obj = new class() {

            #[Image('image', 'uploads')]
            private string $image;
            #[Video('video', dir: 'uploads')]
            private string $video;
            #[Image('gallery', dir: 'uploads')]
            private array $gallery;

            public function getImage(): string
            {
                return $this->image;
            }

            public function getVideo(): string
            {
                return $this->video;
            }

            public function getGallery(): array
            {
                return $this->gallery;
            }

        };

        $_FILES = [
            'image' => [
                'name' => 'test.png',
                'type' => 'image/png',
                'tmp_name' => tempnam(sys_get_temp_dir(), 'test_'),
                'error' => 0,
                'size' => 12345
            ],
            'video' => [
                'name' => 'test.mp4',
                'type' => 'video/mp4',
                'tmp_name' => tempnam(sys_get_temp_dir(), 'test_'),
                'error' => 0,
                'size' => 54321
            ],
            'gallery' => [
                'name' => [
                    'test1.jpg',
                    'test2.jpg',
                    'test3.jpg'
                ],
                'type' => [
                    'image/jpeg',
                    'image/jpeg',
                    'image/jpeg'
                ],
                'tmp_name' => [
                    tempnam(sys_get_temp_dir(), 'test_'),
                    tempnam(sys_get_temp_dir(), 'test_'),
                    tempnam(sys_get_temp_dir(), 'test_'),
                ],
                'error' => [
                    0,
                    0,
                    0
                ],
                'size' => [
                    11111,
                    22222,
                    33333
                ]
            ]
        ];

        File::upload($obj, [
           new FileSize(10) //this will test all the uploaded files and fail if one of them is bigger than 5MB
        ]);

        $this->assertFileExists($this->dir . $obj->getImage());
        $this->assertFileExists($this->dir . $obj->getVideo());
        $this->assertFileExists($this->dir . $obj->getGallery()[0]);
        $this->assertFileExists($this->dir . $obj->getGallery()[1]);
        $this->assertFileExists($this->dir . $obj->getGallery()[2]);

    }

    public function testShouldFailWhenRequiredFilesAreNotProvided(): void
    {
        $obj = new class() {

            #[Image('image', 'uploads')]
            private string $image;
            #[Video('video', dir: 'uploads')]
            private string $video;
            #[Image('gallery', dir: 'uploads', required: false)]
            private array $gallery;

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

        $this->expectException(MissingFileException::class);
        $this->expectExceptionMessage('Missing file for field: video');

        File::upload($obj, [
           new FileSize(10) //this will test all the uploaded files and fail if one of them is bigger than 5MB
        ]);
    }
}