<?php

namespace Didslm\FileUploadWrapper\checker;

interface Checker
{
    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const TYPES = [
        self::JPEG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
    ];

    public function isPassed(array $fileData): bool;
}