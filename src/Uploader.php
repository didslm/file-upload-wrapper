<?php

namespace Didslm\FileUpload;
use Didslm\FileUpload\Exception\MissingFileException;
use Didslm\FileUpload\Factory\TypePropertyFactory;
use Didslm\FileUpload\Factory\UploadedFilesFactory;
use Didslm\FileUpload\Handler\FileUploadDirHandler;
use Didslm\FileUpload\Validation\FieldValidatorInterface;
use Didslm\FileUpload\Validation\validatorInterface;

class Uploader
{
    private static self $instance;
    private array $uploadedFiles = [];
    private array $types;

    private function __construct(private object $targetObject) {}

    public static function upload(object &$obj, array|validatorInterface|null $validators = []): void
    {
        self::$instance = new self($obj);

        self::$instance->uploadedFiles = UploadedFilesFactory::create($_FILES);

        self::$instance->types = TypePropertyFactory::create($obj);

        self::validate($validators);

        self::saveFiles();
    }

    private static function addFilenameToTargetObject(string $fileName, string $property): void
    {
        $object = self::$instance->targetObject;
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($property);

        if ($property->getType()->getName() === 'string') {
            $property->setValue($object, $fileName);
        }

        if ($property->getType()->getName() === 'array') {
            $property->setValue($object, array_merge($property->getValue($object), [$fileName]));
            return;
        }

        $property->setValue($object, $fileName);
    }

    private static function validate(array $validations): void
    {
        $instance = self::$instance;

        foreach ($instance->uploadedFiles as $key => $uploadedFile) {
            $type = self::$instance->types[$uploadedFile->getRequestField()] ?? null;

            if ($type === null) {
                unset($instance->uploadedFiles[$key]); //we don't need it if it's not declared in the object
                continue;
            }

            foreach ($validations as $validation) {

                if ($validation instanceof FieldValidatorInterface && $validation->validateOnlyField() !== $uploadedFile->getRequestField()) {
                    continue;
                }

                $validation->isPassed($uploadedFile);
            }
        }
    }

    private static function saveFiles(): void
    {
        $instance = self::$instance;
        /** @var UploadedFileInterface $file */
        foreach ($instance->uploadedFiles as $k => $file) {
            $type = $instance->types[$file->getRequestField()];

            $newGeneratedFileName = FileUploadDirHandler::generateName($file);
            $file->moveTo(FileUploadDirHandler::getUploadDir($type). $newGeneratedFileName);

            self::addFilenameToTargetObject($newGeneratedFileName, $type->getProperty());
            unset($instance->uploadedFiles[$k]);
        }
    }

}
