<?php

namespace Didslm\FileUpload\Validation;

interface ValidationInterface
{
    /**
     * @throws ValidationException
     */
    public function validate(array $uploadedFiles, array $validations): void;
}
