<?php

namespace Didslm\FileUpload;

class Size
{
    public const KB = 1;
    public const MB = 2;

    public const ALL = [
        self::KB => 1,
        self::MB => 1024,
    ];

}