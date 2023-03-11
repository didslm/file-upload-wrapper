<?php

namespace Didslm\FileUpload;

use PSr\Http\Message\StreamInterface;

class UploadedFile implements UploadedFileInterface
{
    /**
     * @const array
     * @link https://www.php.net/manual/en/features.file-upload.errors.php
     */
    private const ERRORS = [
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive'
            . ' that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
    ];
    
    public function __construct(
        private string $uploadedUnderFieldName,
        private ?string $tmpName,
        private ?string $name,
        private ?string $type,
        private ?int $size,
        private int $error
    ){}

    public function getStream(): StreamInterface
    {
        return new Stream($this->tmpName);
    }

    public function moveTo($targetPath): void
    {
        if ($this->error !== UPLOAD_ERR_OK) {
            throw new \RuntimeException(self::ERRORS[$this->error]);
        }
        
//        if (!is_uploaded_file($this->tmpName)) {
//            throw new \RuntimeException("The file $this->tmpName is not an uploaded file.");
//        }

        if (!copy($this->tmpName, $targetPath)) {
            throw new \RuntimeException("The file $this->tmpName could not be moved to $targetPath.");
        }
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getClientFilename(): ?string
    {
        return $this->name;
    }

    public function getClientMediaType(): ?string
    {
        return $this->type;
    }

    public function getRequestField(): string
    {
        return $this->uploadedUnderFieldName;
    }
}
