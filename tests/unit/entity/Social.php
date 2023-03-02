<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\type\Image;

class Social
{
    #[Image('image', 'public/images')]
    public array $images;

    public function getImages(): array
    {
        return $this->images;
    }
}