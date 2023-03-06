<?php

namespace Didslm\FileUpload\Attribute;

interface TypeInterface
{
    public function getDir(): string;
    public function getRequestField(): string;
    public function isRequired(): bool;
}