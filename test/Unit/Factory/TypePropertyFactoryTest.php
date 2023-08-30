<?php

namespace Didslm\FileUpload\Test\Unit\Factory;

use Didslm\FileUpload\Attribute\Image;
use Didslm\FileUpload\Attribute\TypePropertyDecorated;
use Didslm\FileUpload\Factory\TypePropertyFactory;
use PHPUnit\Framework\TestCase;

class TypePropertyFactoryTest extends TestCase
{
    public function testEntityWithoutAttributes(): void
    {
        $entity = new class {
            public $field;
            public $name = 'test';
        };

        $entity->field = "Test";

        $result = TypePropertyFactory::create($entity);
        $this->assertEmpty($result);
        $this->assertEquals("Test", $entity->field);
        $this->assertEquals("test", $entity->name);
    }

    public function testEntityWithSingleAttribute(): void
    {
        $entity = new class {
            #[Image('field')]
            public $field;
        };

        $result = TypePropertyFactory::create($entity);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(TypePropertyDecorated::class, $result['field']);
        $this->assertEquals("", $entity->field);
    }
}