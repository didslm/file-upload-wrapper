<?php

namespace Didslm\FileUpload;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    /**
     * @var false|resource
     */
    private $stream;

    public function __construct(private string $path, private string $mode = 'a')
    {
        $this->stream = fopen($path, $mode);
        if ($this->stream === false) {
            throw new \RuntimeException('Could not open stream for path: ' . $path);
        }
    }

    public function __toString(): string
    {
        return (string) $this->stream;
    }

    public function close(): void
    {
        $this->stream = null;
    }

    public function detach(): void
    {
        $this->stream = null;
    }

    public function getSize(): int
    {
        return filesize($this->path) ?? 0;
    }

    public function tell(): int
    {
        return ftell($this->stream);
    }

    public function eof(): bool
    {
        return feof($this->stream);
    }

    public function isSeekable(): bool
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET): int
    {
        return fseek($this->stream, $offset, $whence);
    }

    public function rewind(): bool
    {
        return rewind($this->stream);
    }

    public function isWritable(): bool
    {
        return in_array($this->mode, ['w', 'w+']);
    }

    public function write($string): int
    {
        return fwrite($this->stream, $string);
    }

    //check if the stream is readable
    public function isReadable(): bool
    {
        if ($this->stream) {
            return in_array($this->mode, ['r', 'r+', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+']);
        }

        return false;
    }

    public function read($length): string
    {
        return fread($this->stream, $length) ?? '';
    }

    public function getContents(): string
    {
        if ($this->isReadable()) {
            return stream_get_contents($this->stream);
        }

        throw new \RuntimeException('Stream is not readable');
    }

    public function getMetadata($key = null): array|string|null
    {
        if ($key) {
            return stream_get_meta_data($this->stream)[$key];
        }
        return stream_get_meta_data($this->stream);
    }

}