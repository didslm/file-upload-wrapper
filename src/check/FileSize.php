<?php

namespace Didslm\FileUpload\check;

use Didslm\FileUpload\Size;

class FileSize implements Check
{
    public function __construct(private int $size, private ?int $type = Size::MB){}

    public function isPassed(array $fileData): bool
    {
        $fileSize = $fileData['size'];
        $limitSize = $this->size * Size::ALL[$this->type];

        if ($fileSize > $limitSize) {
            throw new CheckUploadException(sprintf('File size is too big. Limit is %s %s.', $this->size, 'MB'));
        }

        return true;
    }
}