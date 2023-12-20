<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\Exception\ValidationException;

use Didslm\FileUpload\File;
use Psr\Http\Message\UploadedFileInterface;

class FileType implements ValidatorInterface
{
    const CHECKER_NAME = 'File Type';

    public function __construct(private readonly array $acceptedTypes = File::ALL){}

    public function isPassed(UploadedFileInterface $file): bool
    {

        if (!in_array($this->getMimeTypeFromContent($file), $this->acceptedTypes, true)) {
            throw new ValidationException(sprintf('File type (%s) is not allowed. Allowed types are %s.',$file->getClientMediaType(), implode(', ', $this->acceptedTypes)));
        }

        return true;
    }

    private function getMimeTypeFromContent(UploadedFileInterface $file): string
    {
        $stream = $file->getStream();
        $stream->rewind();
        $content = $stream->read(1024);
        $stream->close();

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $content);
        finfo_close($finfo);

        return $mimeType;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}