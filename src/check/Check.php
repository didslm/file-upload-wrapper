<?php

namespace Didslm\FileUpload\check;

use Psr\Http\Message\UploadedFileInterface;

interface Check
{
    public function isPassed(UploadedFileInterface $file): bool;
    public function getName(): string;
}