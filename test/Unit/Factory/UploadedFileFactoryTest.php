<?php

namespace Didslm\FileUpload\Test\Unit\Factory;

use Didslm\FileUpload\Factory\UploadedFileFactory;

class UploadedFileFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateReturnsUploadedFileInterface(): void
    {
        $factory = new UploadedFileFactory();

        $files = array(
            'avatar' => array(
                'tmp_name' => 'phpUxcOty',
                'name' => 'my-avatar.png',
                'size' => 90996,
                'type' => 'image/png',
                'error' => 0,
            ),
        );

        $uploadedFiles = $factory->create($files);

        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[0]);
    }

    public function testShouldReturnMultipleUploadedFiles(): void
    {
        $factory = new UploadedFileFactory();

        $files = array(
            'avatar' => array(
                'tmp_name' => 'phpUxcOty',
                'name' => 'my-avatar.png',
                'size' => 90996,
                'type' => 'image/png',
                'error' => 0,
            ),
            'cover' => array(
                'tmp_name' => 'phpUxcOty',
                'name' => 'my-cover.png',
                'size' => 90996,
                'type' => 'image/png',
                'error' => 0,
            ),
        );

        $uploadedFiles = $factory->create($files);

        $this->assertCount(2, $uploadedFiles);
        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[0]);
        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[1]);
    }

    public function testShouldReturnMultipleUploadedFilesInTheSameField(): void
    {
        $factory = new UploadedFileFactory();

        $files = array(
            'avatar' => array(
                'tmp_name' => array(
                    'phpUxcOty',
                    'phpUxcOty',
                ),
                'name' => array(
                    'my-avatar.png',
                    'my-avatar.png',
                ),
                'size' => array(
                    90996,
                    90996,
                ),
                'type' => array(
                    'image/png',
                    'image/png',
                ),
                'error' => array(
                    0,
                    0,
                ),
            ),
        );

        $uploadedFiles = $factory->create($files);

        $this->assertCount(2, $uploadedFiles);
        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[0]);
        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[1]);
    }

    public function testShouldReturnMultipleUploadedFilesWhenArrayAsFieldIsGiven(): void
    {
        $factory = new UploadedFileFactory();

        $files = array (
            'image' => [
                'tmp_name' => 'phpUxcOty',
                'name' => 'my-avatar.png',
                'size' => 90996,
                'type' => 'image/png',
                'error' => 0,
            ],
            'my-form' => array (
                'name' => array (
                    'details' => array (
                        'avatar' => 'my-avatar.png',
                    ),
                ),
                'type' => array (
                    'details' => array (
                        'avatar' => 'image/png',
                    ),
                ),
                'tmp_name' => array (
                    'details' => array (
                        'avatar' => 'phpmFLrzD',
                    ),
                ),
                'error' => array (
                    'details' => array (
                        'avatar' => 0,
                    ),
                ),
                'size' => array (
                    'details' => array (
                        'avatar' => 90996,
                    ),
                ),
            ));

        $uploadedFiles = $factory->create($files);

        $this->assertCount(2, $uploadedFiles);
        $this->assertInstanceOf(\Didslm\FileUpload\UploadedFileInterface::class, $uploadedFiles[0]);
    }

    public function testShouldPassWithMultipleFilesAndSingleFile(): void
    {
        $factory = new UploadedFileFactory();
        $files = [
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

        $uploadedFiles = $factory->create($files);
        $this->assertCount(5, $uploadedFiles);
    }
}
