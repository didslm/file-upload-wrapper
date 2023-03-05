<?php

namespace Didslm\FileUpload\service;

use Psr\Http\Message\UploadedFileInterface;

class UploadedFileCollection implements \IteratorAggregate
{
    public function __construct(private ?array $files = [])
    {

    }

    public function addFile(UploadedFileInterface $file, string $field): void
    {
        $this->files[$field] = array_merge($this->files, [$file]);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->files);
    }
}