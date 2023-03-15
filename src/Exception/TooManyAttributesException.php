<?php

namespace Didslm\FileUpload\Exception;

class TooManyAttributesException extends FileUploadException
{
    public function __construct(string $attribute)
    {
        $message = "Too many attributes defined for field: {$attribute}";
        parent::__construct($message);
    }
}
