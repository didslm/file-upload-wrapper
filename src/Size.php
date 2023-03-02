<?php

namespace Didslm\FileUpload;

class Size
{
    public const KB = 1;
    public const MB = 2;

    public const ALL = [
        self::KB => 1000,
        self::MB => 1000000,
    ];

}