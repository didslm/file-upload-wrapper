<?php

namespace Didslm\FileUploadWrapper\checker;

class FileType implements Checker
{
    const CHECKER_NAME = 'File Type';

    public function __construct(private array $acceptedTypes){}

    public function isPassed(array $fileData): bool
    {
        $fileType = $fileData['type'];

        if (!in_array($fileType, $this->acceptedTypes, true)) {
            throw new CheckException($this, $fileType);
        }

        return true;
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}