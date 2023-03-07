<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\Attribute\Document;

class CvProfile
{
    #[Document('cv', '/documents/cv')]
    public string $cv;

    public function getCv(): string
    {
        return $this->cv;
    }
}