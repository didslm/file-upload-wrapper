<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Exception\MissingFileException;
use Didslm\FileUpload\Exception\ValidationException;
use Didslm\FileUpload\Factory\UploadedFilesFactory;
use Didslm\FileUpload\Validation\iValidator;
use Didslm\FileUpload\service\TypeAttributesCollection;
use Psr\Http\Message\UploadedFileInterface;

final class File
{
    private const DEFAULT_FILE_PREFIX = 'file_';
    private string $generatedName;

    protected function __construct(
        private string $uploadDir,
        private UploadedFileInterface $uploadedFile
    ){}

    /**
     * @throws MissingFileException
     * @throws ValidationException
     */
    public static function upload(object &$obj, ?array $checkers = []): void
    {
        $typesCollection = TypeAttributesCollection::createFromObject($obj);
        $uploadedFiles = UploadedFilesFactory::create($_FILES);

        $uploadedFiles->validate($typesCollection->getRequiredFields());

        
        foreach($uploadedFiles as $field => $uploadedFile) {
            $uploadedFile = array_pop($uploadedFile);

            $type = $typesCollection->getTypeByKey($field);
            $property = $typesCollection->getPropertyByKey($field);

            if ($type === null) {
                continue;
            }

            $file = new self(
                $_SERVER['DOCUMENT_ROOT'] . '/' . trim($type->getDir(), '/') . '/',
                $uploadedFile
            );

            $file->validate(...$checkers);

            if ($file->uploadDirExists() === false) {
                $file->createDir();
            }

            $uploadedFile->moveTo($file->uploadDir . $file->generateName());

            if (is_array($obj->{$property})) {
                $obj->{$property}[] = $file->getGeneratedName();
                continue;
            }

            $obj->{$property} = $file->getGeneratedName();
        }
    }

    private function createDir(): void
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function validate(iValidator... $checkers): void
    {
        foreach ($checkers as $check) {
            if (!$check->isPassed($this->uploadedFile)) {
                throw new ValidationException($check->getName(), $this->uploadedFile->getClientMediaType());
            }
        }
    }

    private function getGeneratedName(): string
    {
        return $this->generatedName ?? $this->generateName();
    }
    private function generateName(): string
    {
        $ext = Type::ALL[$this->uploadedFile->getClientMediaType()];
        return $this->generatedName = md5(uniqid(self::DEFAULT_FILE_PREFIX, true)).'.'.$ext;
    }

    private function uploadDirExists(): bool
    {
        return is_dir($this->uploadDir);
    }
}
