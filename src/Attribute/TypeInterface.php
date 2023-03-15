<?php

namespace Didslm\FileUpload\Attribute;

interface TypeInterface
{
    public const DEFAULT_DIR = 'uploads';
    public function getDir(): string;
    public function getRequestField(): string;
    public function isRequired(): bool;
}
