<?php

namespace Didslm\FileUploadWrapper\filters;

interface FilterInterface
{
    public function checkFile(array $fileData): bool;
}