<?php

namespace Didslm\FileUpload\Validation;

interface FieldValidatorInterface extends ValidatorInterface
{
    public function validateOnlyField(): bool|string;
}