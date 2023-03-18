<?php

namespace Didslm\FileUpload;
use Didslm\FileUpload\Exception\MissingFileException;
use Didslm\FileUpload\Factory\FileNameFactory;
use Didslm\FileUpload\Factory\TypePropertyFactory;
use Didslm\FileUpload\Factory\UploadedFileFactory;
use Didslm\FileUpload\Factory\UploadedFilesFactory;
use Didslm\FileUpload\Handler\FileUploadDirHandler;
use Didslm\FileUpload\Reflection\EntityReflector;
use Didslm\FileUpload\Validation\FieldValidatorInterface;
use Didslm\FileUpload\Validation\validatorInterface;

class Uploader
{
    private static self $instance;
    private array $uploadedFiles = [];
    private array $types;
    private UploaderInterface $uploader;

    private function __construct(private object $targetObject) {
        $this->uploader = new UploaderImpl(
            new ValidationImpl(),
            new UploadedFileFactory(),
            new TypePropertyFactory(),
            new FileNameFactory(),
            new EntityReflector(),
        );
    }

    public static function upload(object &$obj, array|validatorInterface|null $validators = []): void
    {
        self::$instance = new self($obj);
        $obj = self::$instance->uploader->upload($obj, $validators);
    }
    
}
