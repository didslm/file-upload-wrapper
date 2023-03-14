<?php

namespace Didslm\FileUpload\Exception;

class InvalidFileException extends FileUploadException {
    public function __construct($filename) {
        $message = "Failed to open file: $filename";
        parent::__construct($message);
    }
}
