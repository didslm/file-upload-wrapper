<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\check\CheckUploadException;
use Didslm\FileUpload\check\Check;
use Didslm\FileUpload\exception\MissingFileException;
use Didslm\FileUpload\service\TypeAttributesCollection;
use Didslm\FileUpload\service\UploadedFilesFactory;
use Psr\Http\Message\UploadedFileInterface;

final class File
{
    private const DEFAULT_FILE_PREFIX = 'file_';
    private string $generatedName;

    protected function __construct(
        private readonly string $uploadDir,
        private readonly UploadedFileInterface $uploadedFile
    ){}

    public static function upload(object &$obj, ?array $checkers = []): void
    {
        $typesCollection = TypeAttributesCollection::createFromObject($obj);
        $uploadedFiles = UploadedFilesFactory::create($_FILES);

        if ($typesCollection->missingRequiredFile()) {
            throw new MissingFileException();
        }

        foreach($uploadedFiles as $field => $uploadedFile) {
            $uploadedFile = array_pop($uploadedFile);

            $type = $typesCollection->getTypeByKey($field);
            $property = $typesCollection->getPropertyByKey($field);


//            throw new \Exception( print_R($uploadedFile,1));
            if ($type === null) {
                continue;
            }

            $file = new self(
                $_SERVER['DOCUMENT_ROOT'] . '/' . trim($type->getDir(), '/') . '/',
                $uploadedFile
            );

            $file->validate(...$checkers);

//            throw new \Exception( print_R($property,1));
            if ($file->uploadDirExists() === false) {
                $file->createDir();
            }

            $uploadedFile->moveTo($file->uploadDir . $file->generateName());


            $obj->{$property} = $file->getGeneratedName();
        }
    }

    private function createDir(): void
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function validate(Check... $checkers): void
    {
        foreach ($checkers as $check) {
            if (!$check->isPassed($this->uploadedFile)) {
                throw new CheckUploadException($check->getName(), $this->uploadedFile->getClientMediaType());
            }
        }
    }

    private function getGeneratedName(): string
    {
        return $this->generatedName ?? $this->generateName();
    }
    private function generateName(): string
    {
        $ext = Type::TYPES[$this->uploadedFile->getClientMediaType()];
        return $this->generatedName = md5(uniqid(self::DEFAULT_FILE_PREFIX, true)).'.'.$ext;
    }

    private function uploadDirExists(): bool
    {
        return is_dir($this->uploadDir);
    }
}
