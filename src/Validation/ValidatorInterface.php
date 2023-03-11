<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\UploadedFileInterface;

interface ValidatorInterface
{
    public function isPassed(UploadedFileInterface $file): bool;
    public function getName(): string;

}