<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\Attribute\Image;

class Product
{

    #[Image(requestField: "article_image", dir: "/public/images")]
    public string $image;

    public function getImageFilename(): string
    {
        return $this->image;
    }
}