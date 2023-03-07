<?php

namespace Didslm\FileUpload\Validation;

use Psr\Http\Message\UploadedFileInterface;

class RequestFieldValidations implements iFieldValidator
{
    public function __construct(private string $requestField, private array $validations){
        if ($this->requestField === '') {
            throw new \InvalidArgumentException('Request field name cannot be empty string.');
        }
    }


    public function isPassed(UploadedFileInterface $file): bool
    {
        /** @var iValidator $validation */
        foreach ($this->validations as $validation) {
            if ($validation->isPassed($file) === false) {
                return false;
            }
        }
        return true;
    }

    public function validateOnlyField(): bool|string
    {
        return $this->requestField ?? false;
    }

    public function getName(): string
    {
        return $this->requestField;
    }
}