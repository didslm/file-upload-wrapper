<?php

namespace Didslm\FileUploadWrapper;

class Type
{

    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const TYPES = [
        self::JPEG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
    ];

}