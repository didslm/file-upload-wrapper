<?php

namespace Didslm\FileUpload\Exception;

class UploadedFileException extends FileUploadException {
    public function __construct($errorMessage) {
        parent::__construct($errorMessage);
    }
}
