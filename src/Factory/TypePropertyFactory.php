<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\Attribute\TypeInterface;
use Didslm\FileUpload\Attribute\TypePropertyDecorated;
use Didslm\FileUpload\Exception\TooManyAttributesException;

class TypePropertyFactory
{
    public static function create(object $obj): array
    {
        $types = [];
        foreach ((new \ReflectionClass($obj))->getProperties() as $property) {
            $attributes = $property->getAttributes(TypeInterface::class, \ReflectionAttribute::IS_INSTANCEOF);

            if (count($attributes) > 1) {
                throw new TooManyAttributesException($property->getName());
            }

            if (count($attributes) === 1) {
                // Set the property value to an empty string ONLY if it has the TypeInterface attribute
                $property->setAccessible(true);  // Make sure you can access private or protected properties
                $type = $property->getType();
                $property->setValue($obj, $type && $type->getName() === 'array' ? [] : '');

                /** @var TypeInterface $type */
                $type = $attributes[0]->newInstance();
                $types[$type->getRequestField()] = new TypePropertyDecorated($type, $property->getName());
            }
        }

        return $types;
    }

    public function createFromEntity(object $entity): array
    {
        return self::create($entity);
    }
}
