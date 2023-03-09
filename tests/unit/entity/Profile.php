<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\Attribute\Image;

class Profile
{
    private string $name;
    private string $email;
    private string $password;

    #[Image(requestField: "image", dir: "/public/images")]
    public string $image;

    #[Image(requestField: "cover", dir: "/public/images")]
    public string $image2;

    #[Image(requestField: "images", dir: "/public/images", required: false)]
    public array $imgs;

    public function getImageFilename(): string
    {
        return $this->image;
    }

    public function getImage2Filename(): string
    {
        return $this->image2;
    }

    public function getImgs(): array
    {
        return $this->imgs;
    }
}