<?php

namespace Didslm\FileUploadWrapper\service;

use Didslm\FileUploadWrapper\types\TypeInterface;

class TypeExtractorService
{
    private \ReflectionClass $reflection;

    public function __construct(object $object)
    {
        $this->reflection = new \ReflectionClass($object);
    }

    public function getType(): TypeInterface
    {
        foreach ($this->reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(TypeInterface::class, \ReflectionAttribute::IS_INSTANCEOF);
            foreach ($attributes as $attribute) {
                if ($attribute->newInstance() instanceof TypeInterface) {
                    return $attribute->newInstance();
                }
            }
        }

        throw new \Exception('No type found');
    }
}