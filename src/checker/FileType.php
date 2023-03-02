<?php

namespace Didslm\FileUploadWrapper\checker;

class FileType implements Checker
{
    const CHECKER_NAME = 'File Type';

    public function __construct(private readonly array $acceptedTypes){}

    public function isPassed(array $fileData): bool
    {
        $fileType = $fileData['type'];

        if (!in_array($fileType, $this->acceptedTypes, true)) {
            throw new CheckUploadException(sprintf('File type is not allowed. Allowed types are %s.', implode(', ', $this->acceptedTypes)));
        }

        return true;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}