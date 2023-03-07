<?php

namespace Didslm\FileUpload\Exception;

abstract class FileUploadException extends \Exception
{
    private ?FileUploadException $previous;

    public function __construct(string $message, FileUploadException $previous = null){
        parent::__construct();
        $this->message = $message;
        $this->previous = $previous;
    }

    public function getLastException(): ?FileUploadException
    {
        return $this->previous;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}