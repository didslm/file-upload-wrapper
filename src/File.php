<?php

namespace Didslm\FileUploadWrapper;

use Didslm\FileUploadWrapper\service\FileName;
use Didslm\FileUploadWrapper\service\TypeExtractorService;

class File
{
    public static function upload(object &$obj, array $filters): void
    {
        $fileType = (new TypeExtractorService($obj))->getType();

        $firstFile = $_FILES[$fileType->getRequestField()];
        $dir = trim($fileType->getDir(), '/');
        $uploadDir = dirname(__DIR__,1) .'/'.$dir . '/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($filters as $filter) {
            if (!$filter->isPassed()) {
                throw new \Exception('File type is not allowed');
            }
        }

        $fieldName = $firstFile['tmp_name'];


        $newFileName = FileName::getUniqueName($firstFile['type']);
        $r = copy($fieldName, $uploadDir.basename($newFileName));
        if (!$r) {
            throw new \Exception('File upload failed');
        }
        unlink($fieldName);

        $obj->image = $dir.'/'.$newFileName;
    }
}
