<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\Exception\ValidationException;
use Psr\Http\Message\UploadedFileInterface;

class FileType implements iValidator
{
    const CHECKER_NAME = 'File Type';

    public function __construct(private readonly array $acceptedTypes){}

    public function isPassed(UploadedFileInterface $file): bool
    {

        if (!in_array($file->getClientMediaType(), $this->acceptedTypes, true)) {
            throw new ValidationException(sprintf('File type (%s) is not allowed. Allowed types are %s.',$file->getClientMediaType(), implode(', ', $this->acceptedTypes)));
        }

        return true;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}