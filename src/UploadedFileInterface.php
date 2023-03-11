<?php

namespace Didslm\FileUpload;

interface UploadedFileInterface extends \Psr\Http\Message\UploadedFileInterface
{
    public function getRequestField(): string;
}
