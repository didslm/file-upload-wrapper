<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Exception\MissingFileException;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFileCollection implements \IteratorAggregate
{

    public function __construct(private ?array $files = [], private ?array $fields = []){}

    public function addFile(UploadedFileInterface $file, string $field): void
    {
        $this->files[] = $file;
        $this->fields[] = [$field, md5($file->getStream()->getContents())];
    }

    public function validate(array $requiredFields): void
    {
        $fields = array_column($this->fields, 0);

        foreach ($requiredFields as $requiredField) {
            if (in_array($requiredField, $fields) === false) {
                throw new MissingFileException("Missing file for field: $requiredField");
            }
        }
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getField(UploadedFileInterface $uploadedFile): string
    {
        $key = array_search(md5($uploadedFile->getStream()->getContents()), array_column($this->fields, 1));

        return $this->fields[$key][0];
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->files);
    }
}