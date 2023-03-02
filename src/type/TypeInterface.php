<?php

namespace Didslm\FileUpload\type;

interface TypeInterface
{
    public function getDir(): string;
    public function getRequestField(): string;
    public function isRequired(): bool;
}