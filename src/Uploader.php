<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Factory\UploaderFactory;
use Didslm\FileUpload\Validation\ValidatorInterface;

class Uploader
{
    private static self $instance;
    private UploaderInterface $uploader;

    private function __construct(private object $targetObject) {
        $this->uploader = UploaderFactory::create();
    }

    public static function upload(object &$obj, array|ValidatorInterface|null $validators = []): void
    {
        self::$instance = new self($obj);
        $obj = self::$instance->uploader->upload($obj, $validators);
    }
    
}
