<?php

namespace Didslm\FileUpload\service;

use Didslm\FileUpload\Attribute\TypeInterface;

class RequestFileType
{
    public function __construct(
        private TypeInterface $fileType,
        private string $property
    ){}

    public function getFileType(): TypeInterface
    {
        return $this->fileType;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function isRequired(): bool
    {
        return $this->fileType->isRequired();
    }
}