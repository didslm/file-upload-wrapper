<?php

namespace Didslm\FileUploadWrapper\Tests\unit\entity;

use Didslm\FileUploadWrapper\types\Image;

class Product
{

    #[Image(requestField: "article_image", dir: "/images")]
    public string $image;

    public function getImageFilename(): string
    {
        return $this->image;
    }
}