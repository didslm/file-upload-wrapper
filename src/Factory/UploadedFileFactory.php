<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\UploadedFile;
use Didslm\FileUpload\UploadedFileInterface;

class UploadedFileFactory
{
    public function create(array $files): array
    {
        $uploadedFiles = [];

        foreach ($files as $key => $file) {
            $uploadedFiles = array_merge($uploadedFiles, self::processFileArray($key, $file));
        }

        return $uploadedFiles;
    }

    private static function processFileArray(string $key, array $file): array
    {
        $uploadedFiles = [];

        if (is_array($file['tmp_name'])) {
            foreach ($file['tmp_name'] as $nestedKey => $nestedFile) {
                $nestedFileData = [
                    'tmp_name' => $file['tmp_name'][$nestedKey],
                    'name' => $file['name'][$nestedKey],
                    'type' => $file['type'][$nestedKey],
                    'size' => $file['size'][$nestedKey],
                    'error' => $file['error'][$nestedKey],
                ];

                if (is_array($nestedFile)) {
                    $uploadedFiles = array_merge($uploadedFiles, self::processFileArray($key . "[$nestedKey]", $nestedFileData));
                } else {
                    $uploadedFiles[] = self::createSingleFile($key . "[$nestedKey]", $nestedFileData);
                }
            }
        } else {
            $uploadedFiles[] = self::createSingleFile($key, $file);
        }

        return $uploadedFiles;
    }

    private static function createSingleFile(string $key, array $file): UploadedFileInterface
    {
        return new UploadedFile(
            $key,
            $file['tmp_name'],
            $file['name'],
            $file['type'],
            $file['size'],
            $file['error']
        );
    }
}
