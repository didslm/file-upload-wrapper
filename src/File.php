<?php

namespace Didslm\FileUploadWrapper;

use Didslm\FileUploadWrapper\checker\CheckException;
use Didslm\FileUploadWrapper\checker\FileType;
use Didslm\FileUploadWrapper\checker\checker;
use Didslm\FileUploadWrapper\service\TypeAttributesCollection;

final class File
{
    private const DEFAULT_FILE_PREFIX = 'file_';
    private string $generatedName;

    protected function __construct(
        readonly string $uploadDir,
        readonly array $uploadedFileData
    ){}

    public static function upload(object &$obj, ?array $checkers = []): void
    {
        $typesCollection = TypeAttributesCollection::createFromObject($obj);
        $uploadedFile = $_FILES[$typesCollection->getType()->getRequestField()];

        $file = new self(
            $_SERVER['DOCUMENT_ROOT'] .'/'. trim($typesCollection->getType()->getDir(), '/') . '/',
            $uploadedFile
        );

        $file->validate(...$checkers);

        if ($file->uploadDirExists() === false) {
            $file->createDir();
        }

        $file->saveFile();

        $obj->{$typesCollection->getProperty()} = $file->getGeneratedName();
    }

    private function saveFile(): void
    {
        $r = copy($this->uploadedFileData['tmp_name'], $this->uploadDir . $this->generateName());
        if (!$r) {
            throw new \Exception('File upload failed');
        }
        unlink($this->uploadedFileData['tmp_name']);
    }

    private function createDir(): void
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function validate(checker... $checkers): void
    {
        foreach ($checkers as $check) {
            if (!$check->isPassed($this->uploadedFileData)) {
                throw new CheckException($check, $this->uploadedFileData['type']);
            }
        }
    }

    private function getGeneratedName(): string
    {
        return $this->generatedName ?? $this->generateName();
    }
    private function generateName(): string
    {
        return $this->generatedName = md5(uniqid(self::DEFAULT_FILE_PREFIX, true)).'.'.FileType::TYPES[$this->uploadedFileData['type']];
    }

    private function uploadDirExists(): bool
    {
        return is_dir($this->uploadDir);
    }
}
