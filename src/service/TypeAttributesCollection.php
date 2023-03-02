<?php

namespace Didslm\FileUploadWrapper\service;

use Didslm\FileUploadWrapper\types\TypeInterface;

class TypeAttributesCollection implements \IteratorAggregate
{
    private array $types;

    private function __construct(array $propertyTypes = []){
        $this->types = $propertyTypes;
    }

    public static function createFromObject(object $object): self
    {
        $types = [];
        $reflection = new \ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(TypeInterface::class, \ReflectionAttribute::IS_INSTANCEOF);
            foreach ($attributes as $attribute) {
                if ($attribute->newInstance() instanceof TypeInterface) {
                    $types[$property->getName()] = $attribute->newInstance();
                }
            }
        }
        return new self($types);
    }

    public function getType(): TypeInterface
    {
        return $this->types[array_key_last($this->types)];
    }

    public function getProperty(): string
    {
        return array_key_last($this->types);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->types);
    }
}