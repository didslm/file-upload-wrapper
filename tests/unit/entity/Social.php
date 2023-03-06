<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\Attribute\Image;

class Social
{
    #[Image('images', 'public/images')]
    public array $images;

    public function getImages(): array
    {
        return $this->images;
    }
}