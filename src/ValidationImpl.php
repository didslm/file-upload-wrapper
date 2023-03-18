<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Validation\FieldValidatorInterface;

class ValidationImpl implements ValidationInterface
{
    public function validate(
        array $uploadedFiles, 
        array $validations
    ): void
    {
        /** @var UploadedFileInterface $uploadedFile */
        foreach ($uploadedFiles as $uploadedFile) {
            $this->validateFile($uploadedFile, $validations);
        }

      
    }

    private function validateFile(
        UploadedFileInterface $uploadedFile, 
        array $validations
    ): void
    {
        foreach ($validations as $validation) {
            if ($validation instanceof FieldValidatorInterface && $validation->validateOnlyField() !== $uploadedFile->getRequestField()) {
                continue;
            }

           $validation->isPassed($uploadedFile);
       }
    }
}
