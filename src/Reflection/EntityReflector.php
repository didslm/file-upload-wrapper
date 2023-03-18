<?php

namespace Didslm\FileUpload\Reflection;

class EntityReflector {

    private object $targetObject;

    public function reflect(object $entity) {
        $this->targetObject = $entity;
        return $this;
    }

    public function set(string $property, string $value): object
    {
        $reflection = new \ReflectionClass($this->targetObject);
        $property = $reflection->getProperty($property);

        if ($property->getType()->getName() === 'string') {
            $property->setValue($this->targetObject, $value);
        }

        if ($property->getType()->getName() === 'array') {
            $property->setValue($this->targetObject, array_merge($property->getValue($this->targetObject), [$value]));
        }

        return $this->targetObject;
    }
}
