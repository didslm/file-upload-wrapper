<?php

namespace Didslm\FileUploadWrapper\service;

use Didslm\FileUploadWrapper\filters\FileType;

class FileName
{
    private const DEFAULT_PREFIX = 'file_';

    public static function getUniqueName(string $fileType): string
    {
        return md5(uniqid(self::DEFAULT_PREFIX, true)).'.'.FileType::TYPES[$fileType];
    }
}