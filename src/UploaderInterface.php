<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Exception\ValidationException;

interface UploaderInterface
{
    /**
     * @throws ValidationException
     */
    public function upload(object &$entity, array $validations): object;
}
