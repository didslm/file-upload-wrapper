<?php

namespace Didslm\FileUpload\check;

interface Check
{
    public function isPassed(array $fileData): bool;
}