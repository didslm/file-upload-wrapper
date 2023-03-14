<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\Stream;
use Psr\Http\Message\StreamInterface;

class StreamFactory
{
    public static function createStreamFromFile(string $file): StreamInterface
    {
        return new Stream($file, 'r');
    }

    public function createStream(string $fileName): StreamInterface
    {
        return new Stream($fileName, 'r');
    }
}