<?php

namespace Didslm\FileUpload\Exception;

class FileNotReadableException extends FileUploadException {
    public function __construct($filename) {
        $message = "File not readable: $filename";
        parent::__construct($message);
    }
}
