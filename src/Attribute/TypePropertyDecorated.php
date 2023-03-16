<?php

namespace Didslm\FileUpload\Attribute;

class TypePropertyDecorated implements TypeInterface {
    
    public function __construct(private TypeInterface $type, private string $property){}

    public function getDir(): string
    {
        return $this->type->getDir();
    }

    public function getRequestField(): string
    {
        return $this->type->getRequestField();
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
