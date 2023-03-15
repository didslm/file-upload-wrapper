<?php

namespace Didslm\FileUpload\Exception;

class ValidationException extends FileUploadException
{
    public function __construct(string $message, FileUploadException $previous = null)
    {
        parent::__construct($message, $previous);
    }
}