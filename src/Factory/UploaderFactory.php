<?php 

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\Reflection\EntityReflector;
use Didslm\FileUpload\UploaderImpl;
use Didslm\FileUpload\UploaderInterface;
use Didslm\FileUpload\ValidationImpl;

class UploaderFactory 
{
    public static function create(): UploaderInterface
    {
        return new UploaderImpl(
            new ValidationImpl(),
            new UploadedFileFactory(),
            new TypePropertyFactory(),
            new FileNameFactory(),
            new EntityReflector(),
        );
    }
}