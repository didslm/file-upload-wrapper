<?php

namespace Didslm\FileUpload\Tests\unit;

use Didslm\FileUpload\service\UploadedFile;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class UploadedFileTest extends TestCase
{
    private const TEST_FILE_PATH = 'path/to/test/file';

    public function testGetStreamReturnsStreamInterface()
    {
        $uploadedFile = new UploadedFile(
            '/tmp/php1234asd',
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_OK
        );

        $stream = $uploadedFile->getStream();

        $this->assertInstanceOf(StreamInterface::class, $stream);
    }

    public function testMoveToThrowsRuntimeExceptionIfErrorOccurred()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_CANT_WRITE
        );

        $this->expectException(\RuntimeException::class);

        $uploadedFile->moveTo('/path/to/target');
    }

    public function testMoveToThrowsRuntimeExceptionIfTargetPathNotWritable()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_OK
        );

        $this->expectException(\RuntimeException::class);

        $uploadedFile->moveTo('/non/writable/path');
    }

    public function testMoveToThrowsRuntimeExceptionIfTmpFileNotUploaded()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_OK
        );

        $this->expectException(\RuntimeException::class);

        $uploadedFile->moveTo('/path/to/target');
    }

    public function testGetSizeReturnsSize()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_OK
        );

        $size = $uploadedFile->getSize();

        $this->assertSame(123, $size);
    }

    public function testGetErrorReturnsError()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_INI_SIZE
        );

        $error = $uploadedFile->getError();

        $this->assertSame(UPLOAD_ERR_INI_SIZE, $error);
    }

    public function testGetClientFilenameReturnsFilename()
    {
        $uploadedFile = new UploadedFile(
            self::TEST_FILE_PATH,
            'test.txt',
            'text/plain',
            123,
            UPLOAD_ERR_OK
        );

        $filename = $uploadedFile->getClientFilename();

        $this->assertSame('test.txt', $filename);

    }

}