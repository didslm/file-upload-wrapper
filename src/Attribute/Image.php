<?php

namespace Didslm\FileUpload\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Image implements TypeInterface
{
    public function __construct(public string $requestField, public string $dir, public bool $required = true){}

    public function getDir(): string
    {
        return $this->dir;
    }


    public function getRequestField(): string
    {
        return $this->requestField;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}