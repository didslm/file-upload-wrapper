<?php

namespace Didslm\FileUpload\Exception;

class MissingFileException extends FileUploadException
{
    public function __construct(string $filename)
    {
        $message = "File not found: $filename";
        parent::__construct($message);
    }

}
