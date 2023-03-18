<?php

namespace Didslm\FileUpload;

interface ValidationInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(array $uploadedFiles, array $validations): void;
}
