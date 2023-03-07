<?php

namespace Didslm\FileUpload\Validation;

interface iFieldValidator extends iValidator
{
    public function validateOnlyField(): bool|string;
}