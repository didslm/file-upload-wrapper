<?php

namespace Didslm\FileUploadWrapper\Factory;

use Didslm\FileUpload\Stream;
use Psr\Http\Message\StreamInterface;

class StreamFactory
{
    public function createStream(string $fileName): StreamInterface
    {
        return new Stream($fileName, 'r+w');
    }
}