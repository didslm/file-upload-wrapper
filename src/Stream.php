<?php

namespace Didslm\FileUpload;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    /**
     * @var false|resource
     */
    private $stream;

    public function __construct(private string $path, private string $mode = 'r')
    {
        $this->stream = fopen($path, $mode);
    }
    public function __toString(): string
    {
        return (string) $this->stream;
    }

    public function close(): void
    {
        $this->stream = null;
    }

    public function detach()
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

    public function isSeekable()
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

    public function isReadable(): bool
    {
        return in_array($this->mode, ['r', 'r+']);
    }

    public function read($length): string
    {
        return fread($this->stream, $length) ?? '';
    }

    public function getContents(): string
    {
        return stream_get_contents($this->stream);
    }

    public function getMetadata($key = null): array|string|null
    {
        if ($key) {
            return stream_get_meta_data($this->stream)[$key];
        }
        return stream_get_meta_data($this->stream);
    }

}