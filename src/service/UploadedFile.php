<?php

namespace Didslm\FileUpload\service;

use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
    public function __construct(
        private ?string $tmpName,
        private ?string $name,
        private ?string $type,
        private ?int $size,
        private int $error
    ){}
    public function getStream()
    {

    }

    public function moveTo($targetPath)
    {
        if (copy($this->tmpName, $targetPath)) {
            unlink($this->tmpName);
        }
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getClientFilename(): ?string
    {
        return $this->name;
    }

    public function getClientMediaType(): ?string
    {
        return $this->type;
    }
}