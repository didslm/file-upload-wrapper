<?php

namespace Didslm\FileUpload\Validation;

use Psr\Http\Message\UploadedFileInterface;

interface iValidator
{
    public function isPassed(UploadedFileInterface $file): bool;
    public function getName(): string;

}