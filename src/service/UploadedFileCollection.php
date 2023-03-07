<?php

namespace Didslm\FileUpload\service;

use Didslm\FileUpload\Exception\MissingFileException;
use http\Encoding\Stream;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileCollection implements \IteratorAggregate
{

    public function __construct(private ?array $files = [], private ?array $fields = []){}

    public function addFile(UploadedFileInterface $file, string $field): void
    {
        $this->files[] = $file;
        $this->fields[$field] = md5($file->getStream()->getContents());
    }

    public function validate(array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if ($this->fields[$field] === null) {
                throw new MissingFileException("Missing file for field: $field");
            }
        }
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getField(UploadedFileInterface $uploadedFile): string
    {
        return array_search(md5($uploadedFile->getStream()->getContents()), $this->fields);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->files);
    }
}