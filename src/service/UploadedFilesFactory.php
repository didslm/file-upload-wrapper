<?php

namespace Didslm\FileUpload\service;

use Psr\Http\Message\UploadedFileInterface;

class UploadedFilesFactory
{
    public static function create(array $files): UploadedFileCollection
    {
        $uploadedFiles = new UploadedFileCollection();
        foreach ($files as $key => $file) {

            //add files if they are from the same field
            throw new \Exception(print_r($file,1));
            if (is_array($file['name'])) {
                for ($i=0; $i < count($file['name']); $i++) {
                    $uploadedFiles->addFile(new UploadedFile(
                        $file['tmp_name'][$i],
                        $file['name'][$i],
                        $file['type'][$i],
                        $file['size'][$i],
                        $file['error'][$i],
                    ), $key);
                }
                continue;
            }

            $uploadedFiles->addFile(new UploadedFile(
                $file['tmp_name'],
                $file['name'],
                $file['type'],
                $file['size'],
                $file['error'],
            ), $key);
        }

        return $uploadedFiles;

    }
}