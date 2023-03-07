<?php

namespace Didslm\FileUpload\Tests\unit;

use Didslm\FileUpload\Exception\ValidationException;
use Didslm\FileUpload\Validation\Dimension;
use Didslm\FileUpload\Validation\FileSize;
use Didslm\FileUpload\Exception\FileUploadException;
use Didslm\FileUpload\Exception\MissingFileException;
use Didslm\FileUpload\File;
use Didslm\FileUpload\Validation\FileType;
use Didslm\FileUpload\Size;
use Didslm\FileUpload\Tests\unit\entity\Product;
use Didslm\FileUpload\Tests\unit\entity\Profile;
use Didslm\FileUpload\Tests\unit\entity\Social;
use Didslm\FileUpload\Type;
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
        $this->expectExceptionMessage('Missing file for field: article_image');

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

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('File size is too big. Limit is 2 MB.');

        File::upload($product, [
            new FileType([Type::JPEG]),
            new FileSize(2, Size::MB)
        ]);
    }

    public function testShouldThrowExceptionWhenDimensionsAreBiggerThanExpected(): void
    {
       //create a temp file with dimensions 200x200
        $this->loadRealImage('article_image', 'image.png');

        $product = new Product();

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('File dimensions are too big. Limit is 200 by 200.');

        File::upload($product, [
            new FileType([Type::JPEG, Type::PNG]),
            new FileSize(4),
            new Dimension(200, 200)
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

    public function testShouldHandleMultipleFilesFromSameField()
    {
        $this->uploadFiles('images');

        $social = new Social();

        File::upload($social, [
            new FileType([Type::JPEG]),
            new FileSize(4, Size::MB)
        ]);

        $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/public/images/';

        list($image, $image2) = $social->getImages();

        self::assertFileExists($fileDir . $image);
        self::assertFileExists($fileDir . $image2);
        self::assertNotEquals($image, $image2);
    }

    /**
     * Example form input 
     * <input type="file" name="my-form[details][avatar]" />
     */
    public function testShouldHandleDeeperLevelsOfFormNames()
    {
        $this->uploadFilesWithDeeperLevelsOfArrays('images');

        $social = new Social();

        File::upload($social, [
            new FileType([Type::PNG]),
            new FileSize(4, Size::MB)
        ]);

        $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/public/images/';

        [$image] = $social->getImages();
        self::assertFileExists($fileDir . $image);
    }

    private function uploadFile(string $string, string $dimensions = '100x100')
    {
        $_FILES[$string] = [
            'name' => $string.'_testimg.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '/tmp/test'.$string.'.jpg',
            'error' => 0,
            'size' => 1000000 * 3 // 3 MB
        ];

        exec('"test" > /tmp/test'.$string.'.jpg');
        exec('convert -size '.$dimensions.' xc:white /tmp/test'.$string.'.jpg');
    }

    /**
     * the input name "files", 
     * submitting images[0] and images[1] — PHP will represent this as:
     */
    private function uploadFiles(string $string): void
    {
        $_FILES[$string] = [

                'name' => [
                        0 => 'IMG_20220925_180633.jpg',
                        1 => 'testing.jpg',
                ],
                'full_path' => [
                        0 => 'IMG_20220925_180633.jpg',
                        1 => 'testing.jpg',
                    ],
                'type' => [
                        0 => 'image/jpeg',
                        1 => 'image/jpeg',
                    ],
                'tmp_name' => [
                        0 => '/tmp/phpwJ8wnP',
                        1 => '/tmp/php4FPCjN',
                    ],
                'error' => [
                        0 => 0,
                        1 => 0,
                    ],
                'size' => [
                        0 => 1245045,
                        1 => 212844,
                    ],
            ];

        exec('"test" > /tmp/phpwJ8wnP');
        exec('"test" > /tmp/php4FPCjN');
    }

    public function uploadFilesWithDeeperLevelsOfArrays(string $key) 
    {
        $_FILES[$key] =  array (
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
                        'avatar' => '/tmp/phpwJ8wnP',
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
        );
        exec('"test" > /tmp/phpwJ8wnP');
    }

    private function loadRealImage(string $string, string $image): void
    {
        $_FILES[$string] = [
            'name' => $image,
            'type' => 'image/png',
            'tmp_name' => __DIR__ . '/Image/' . $image,
            'error' => 0,
            'size' => 1000000 * 3 // 3 MB
        ];
    }
}
