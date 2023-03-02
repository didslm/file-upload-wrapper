<?php

namespace Didslm\FileUploadWrapper\checker;

class CheckException extends \Exception
{
    public function __construct(private Checker $checker, string $actualType)
    {
        parent::__construct();
        $this->message = "File type {$actualType} is not allowed.";
    }

    public function getFailedCheck(): Checker
    {
        return $this->checker;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}