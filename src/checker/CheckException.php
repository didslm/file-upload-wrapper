<?php

namespace Didslm\FileUploadWrapper\checker;

class CheckException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct();
        $this->message = $message;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}