<?php

namespace Didslm\FileUpload\Tests\unit\entity;

use Didslm\FileUpload\type\Image;

class Profile
{
    private string $name;
    private string $email;
    private string $password;

    #[Image(requestField: "image", dir: "/public/images")]
    public string $image;

    #[Image(requestField: "cover", dir: "/public/images")]
    public string $image2;

    public function getImageFilename(): string
    {
        return $this->image;
    }

    public function getImage2Filename(): string
    {
        return $this->image2;
    }
}