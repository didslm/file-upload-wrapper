<?php

namespace Didslm\FileUploadWrapper\types;

interface TypeInterface
{
    public function getDir(): string;
    public function getRequestField(): string;
}