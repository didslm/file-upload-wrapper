<?php

namespace Didslm\FileUploadWrapper\filters;

class FileType implements FilterInterface
{
    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const TYPES = [
        self::JPEG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
    ];

    public function __construct(private array $types){}

    public function isPassed(): bool
    {
        $fileToUpload = $_FILES['article_image'];

        //get current file type
        $fileType = $fileToUpload['type'];

        return in_array($fileType, $this->types, true);
    }
}