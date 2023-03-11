<?php

namespace Didslm\FileUpload\Handler;

use Didslm\FileUpload\Attribute\TypeInterface;
use Didslm\FileUpload\File;
use Didslm\FileUpload\UploadedFile;

class FileUploadDirHandler
{
    private const DEFAULT_FILE_PREFIX = 'file_';

    private function __construct(){}

    public static function generateName(UploadedFile $file): string
    {
        $ext = File::ALL[$file->getClientMediaType()];
        return md5(uniqid(self::DEFAULT_FILE_PREFIX, true)).'.'.$ext;
    }

    public static function getUploadDir(TypeInterface $type): string
    {
        //prepare dir
        $rootDir = $_SERVER['DOCUMENT_ROOT'] . '/';
        $uploadDir = $rootDir . trim($type->getDir(), '/') . '/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        return $uploadDir;
    }

}
