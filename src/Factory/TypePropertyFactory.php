<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\Attribute\TypeInterface;
use Didslm\FileUpload\Attribute\TypePropertyDecorated;

class TypePropertyFactory
{
    public static function create(object $obj): array
    {
        $types = [];
        foreach ((new \ReflectionClass($obj))->getProperties() as $property) {
            $attributes = $property->getAttributes(TypeInterface::class, \ReflectionAttribute::IS_INSTANCEOF);
            $property->setValue($obj, $property->getType()->getName() === 'array' ? [] : '');

            if (count($attributes) > 1) {
                throw new \Exception('You can only have one Type attribute per property');
            }

            if (count($attributes) === 1) {
                /** @var TypeInterface $type */
                $type = $attributes[0]->newInstance();
                $types[$type->getRequestField()] = new TypePropertyDecorated($type, $property->getName());
            }
        }

        return $types;
    }
}