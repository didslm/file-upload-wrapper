<?php

namespace Didslm\FileUpload;

use Didslm\FileUpload\Factory\FileNameFactory;
use Didslm\FileUpload\Factory\TypePropertyFactory;
use Didslm\FileUpload\Factory\UploadedFileFactory;
use Didslm\FileUpload\Reflection\EntityReflector;

class UploaderImpl implements UploaderInterface
{

    private string $rootDirectoy;

    public function __construct(
        private ValidationInterface $validator, 
        private UploadedFileFactory $uploadedFilesFactory,
        private TypePropertyFactory $typeFactory,
        private FileNameFactory $fileNameFactory,
        private EntityReflector $entityReflector,
    ){
        $this->rootDirectoy = $_SERVER['DOCUMENT_ROOT'] .'/';
    }


    public function upload(object &$entity, array $validations): object
    {
        
        $uploadedFiles = $this->uploadedFilesFactory->create($_FILES);
        
        $this->validator->validate($uploadedFiles, $validations);

        $types = $this->typeFactory->createFromEntity($entity);


        foreach ($uploadedFiles as $key => $uploadedFile) {
            $type = $types[$uploadedFile->getRequestField()] ?? null;

            if ($type === null) {
                unset($uploadedFiles[$key]); //we don't need it if it's not declared in the object
                continue;
            }

            $newFileName = $this->generateFileName($uploadedFile);
            $this->saveUploadedFile($uploadedFile, $type->getDir() . '/' . $newFileName);
            $this->assignValueToEntity($entity, $type->getProperty(), $newFileName);

        }

        return $entity;
    }

    private function saveUploadedFile(UploadedFile $uploadedFile, string $uploadTo): void
    {
       
        $uploadedFile->moveTo(
            $this->rootDirectoy . 
            $uploadTo
        );
    }

    private function generateFileName(UploadedFile $uploadedFile): string
    {
        return $this->fileNameFactory->create($uploadedFile->getClientMediaType());
    }

    private function assignValueToEntity(object $entity, string $property, string $value): void
    {
        $this->entityReflector
        ->reflect($entity)
        ->set($property, $value);
    }
}
