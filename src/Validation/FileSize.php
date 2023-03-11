<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\Exception\ValidationException;
use Didslm\FileUpload\File;
use Psr\Http\Message\UploadedFileInterface;

class FileSize implements ValidatorInterface
{
    const CHECKER_NAME = 'File Size';
    public function __construct(private int $size, private ?int $type = File::MB){}

    public function isPassed(UploadedFileInterface $file): bool
    {
        $limitSize = File::ALL_SIZES[$this->type] * $this->size;

        if ($file->getSize() > $limitSize) {
            throw new ValidationException(
                sprintf('File size is too big. Limit is %s %s.', $this->size, 'MB'),
                new ValidationException('Potentialy check you PHP ini configuration, if your file size limit is bigger than the limit you defined in your code.')
            );
        }

        return true;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}