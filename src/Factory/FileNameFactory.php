<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\File;

class FileNameFactory
{
    private const DEFAULT_FILE_PREFIX = 'file_';

    public function create(string $mediaType): string
    {
        $ext = File::ALL[$mediaType];
        return md5(uniqid(self::DEFAULT_FILE_PREFIX, true)).'.'.$ext;
    }
}
