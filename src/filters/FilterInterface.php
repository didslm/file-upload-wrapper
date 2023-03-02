<?php

namespace Didslm\FileUploadWrapper\filters;

interface FilterInterface
{
    public function isPassed(): bool;
}