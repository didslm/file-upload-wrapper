<?php

namespace Didslm\FileUpload\service;

use Didslm\FileUpload\type\TypeInterface;

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
                $type = $attribute->newInstance();
                if ($type instanceof TypeInterface) {
                    $types[] = new RequestFileType($type, $property->getName());
                }
            }
        }
        return new self($types);
    }

    public function missingRequiredFile(): bool
    {
        foreach ($this->types as $type) {
            if ($type->isRequired() && !isset($_FILES[$type->getFileType()->getRequestField()])) {
                return true;
            }
        }
        return false;
    }

    public function getType(): TypeInterface
    {
        return $this->types[array_key_last($this->types)]->getFileType();
    }

    //get type by property name
    public function getTypeByKey(string $property): ?TypeInterface
    {
        /** @var RequestFileType $type */
        foreach ($this->types as $type) {
            if ($type->getFileType()->getRequestField() === $property) {
                return $type->getFileType();
            }
        }
        return null;
    }

    public function getPropertyByKey(string $property): ?string
    {
        /** @var RequestFileType $type */
        foreach ($this->types as $type) {
            if ($type->getFileType()->getRequestField() === $property) {
                return $type->getProperty();
            }
        }
        return null;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->types);
    }
}