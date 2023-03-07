<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\Exception\ValidationException;
use Didslm\FileUpload\Size;
use Psr\Http\Message\UploadedFileInterface;

class FileSize implements iValidator
{
    const CHECKER_NAME = 'File Size';
    public function __construct(private int $size, private ?int $type = Size::MB){}

    public function isPassed(UploadedFileInterface $file): bool
    {
        $limitSize = Size::ALL[$this->type] * $this->size;

        if ($file->getSize() > $limitSize) {
            throw new ValidationException(sprintf('File size is too big. Limit is %s %s.', $this->size, 'MB'));
        }

        return true;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}