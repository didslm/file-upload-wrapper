<?php

namespace Didslm\FileUploadWrapper\exception;

class MissingFileException extends \Exception
{
    protected $message = 'Missing required file.';
}