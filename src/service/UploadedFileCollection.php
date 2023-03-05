<?php

namespace Didslm\FileUpload\service;

use Didslm\FileUpload\exception\MissingFileException;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileCollection implements \IteratorAggregate
{
    public function __construct(private ?array $files = []){}

    public function addFile(UploadedFileInterface $file, string $field): void
    {
        if (isset($this->files[$field]) === false) {
            $this->files[$field] = [];
        }

        $this->files[$field] = array_merge($this->files[$field], [$file]);
    }

    public function validate(array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if (isset($this->files[$field]) === false) {
                throw new MissingFileException();
            }
        }
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->files);
    }
}