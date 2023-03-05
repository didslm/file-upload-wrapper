<?php

namespace Didslm\FileUpload\type;

abstract class UploadableType
{
    public function __set(string $name, $value)
    {
        if ($this->$name )
        $this->$name = $value;
    }
}