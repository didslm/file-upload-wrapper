<?php

namespace Didslm\FileUpload;

class Type
{

    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const ALL = [
        self::JPEG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
    ];

}