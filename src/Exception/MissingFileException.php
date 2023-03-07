<?php

namespace Didslm\FileUpload\Exception;

class MissingFileException extends \Exception
{
    protected $message = 'Missing required file.';
}