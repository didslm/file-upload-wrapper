<?php

namespace Didslm\FileUpload;

use Psr\Http\Message\UploadedFileInterface as PsrUploadedFileInterface;

interface UploadedFileInterface extends PsrUploadedFileInterface
{
    public function getRequestField(): string;
}
