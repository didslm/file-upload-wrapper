<?php

namespace Didslm\FileUpload\Factory;

use Didslm\FileUpload\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFilesFactory
{
    private function __construct(private array $files){}
    
    public static function create(array $files): array
    {
        $factory = new self($files);
        $uploadedFiles = [];
        
        foreach ($files as $key => $file) {

            if ($factory->isMultiple($key)) {
                $normalizedFiles = $factory->normalizeMultiple($key);
                
                for ($i=0; $i < count($normalizedFiles['name']); $i++) {

                    $uploadedFiles[] = new UploadedFile(
                        $key,
                        $normalizedFiles['tmp_name'][$i],
                        $normalizedFiles['name'][$i],
                        $normalizedFiles['type'][$i],
                        $normalizedFiles['size'][$i],
                        (int) $normalizedFiles['error'][$i],
                    );
                }
                continue;
            }

            $file['request_field'] = $key;
            $uploadedFiles[] = $factory->createFile($file);
        }

        return $uploadedFiles;
    }

    private function isMultiple(string $key): bool
    {
        return is_array($this->files[$key]['name']);
    }

    private function normalizeMultiple(string $key): array
    {
        return [
                'name' => $this->extractLastArray($this->files[$key]['name']),
                'type' => $this->extractLastArray($this->files[$key]['type']),
                'tmp_name' => $this->extractLastArray($this->files[$key]['tmp_name']),
                'error' => $this->extractLastArray($this->files[$key]['error']),
                'size' => $this->extractLastArray($this->files[$key]['size']),
        ];
    }

    private function extractLastArray(array $data): array
    {
        $firstItem = $data[array_key_first($data)];

        if (is_array($firstItem)) {
            return $this->extractLastArray($firstItem);
        }

        return array_values($data);
    }

    private function createFile(array $file): UploadedFileInterface
    {
        return new UploadedFile(
            $file['request_field'],
            $file['tmp_name'],
            $file['name'],
            $file['type'],
            $file['size'],
            $file['error'],
        );
    }
}