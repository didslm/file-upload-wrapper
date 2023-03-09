<?php

namespace Didslm\FileUpload\Tests\unit;

use Didslm\FileUpload\{Factory\StreamFactory, File, UploadedFile, Stream, Type};
use Didslm\FileUpload\Tests\unit\entity\CvProfile;
use Didslm\FileUpload\Validation\FileType;
use PHPUnit\Framework\TestCase;

class DocumentUploadTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $_FILES = [];
        $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__, 2);
        $this->dir = dirname(__DIR__, 2) . '/documents/cv/';
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $_FILES = [];

        $fileDir = dirname(__DIR__, 2) . '/documents';
        exec("rm -rf $fileDir");
    }

    public function testShouldUploadPdfSuccessfully(): void
    {
        $_FILES = $this->mockFileUpload('cv', 'test.cv.pdf', 'testing the test \n test', 'application/pdf');

        $product = new CvProfile();

        File::upload($product, [
            new FileType([Type::PDF])
        ]);

        self::assertFileExists($this->dir . $product->getCv());
    }

    function mockFileUpload($fieldName, $filename, $content, $type): array {


        $tmpfile = tmpfile();
        if ($tmpfile === false) {
            throw new \Exception('Could not create temporary file.');
        }

        fwrite($tmpfile, $content);

        // Build the file upload array.
        $file = [
            'name' => $filename,
            'type' => $type,
            'tmp_name' => stream_get_meta_data($tmpfile)['uri'],
            'error' => UPLOAD_ERR_OK,
            'size' => strlen($content)
        ];

        fclose($tmpfile);

        return [
            $fieldName => $file
        ];
    }

}