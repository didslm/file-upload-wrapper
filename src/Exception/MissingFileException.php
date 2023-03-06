<?php

namespace Didslm\FileUpload\exception;

class MissingFileException extends \Exception
{
    protected $message = 'Missing required file.';
}