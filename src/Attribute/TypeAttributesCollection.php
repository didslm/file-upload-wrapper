<?php

namespace Didslm\FileUpload\Attribute;

use Didslm\FileUpload\RequestFileType;

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
            $property->setAccessible(true);
            if ($property->getType()->getName() === 'array') {
                $property->setValue($object, []);
            } else {
                $property->setValue($object, '');
            }


            if (count($attributes) >= 2) {
                    //throw new ToManyTypesException("To many types for property: {$property->getName()}");
            }

            [$type] = $attributes;
            if ($type !== null) {
                $types[] = new RequestFileType($type->newInstance(), $property->getName());
            }

        }
        return new self($types);
    }

    public function getRequiredFields(): array
    {
        $requiredFields = [];
        foreach ($this->types as $type) {
            if ($type->isRequired()) {
                $requiredFields[] = $type->getFileType()->getRequestField();
            }
        }
        return $requiredFields;

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