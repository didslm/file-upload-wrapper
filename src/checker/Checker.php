<?php

namespace Didslm\FileUploadWrapper\checker;

interface Checker
{
    public function isPassed(array $fileData): bool;
}