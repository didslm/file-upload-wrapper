<?php

namespace Didslm\FileUpload\Validation;

use Didslm\FileUpload\Exception\ValidationException;
use Psr\Http\Message\UploadedFileInterface;
class Dimension implements ValidatorInterface
{
    const CHECKER_NAME = 'Image Dimension';

    public function __construct(private float $width, private float $height){}

    public function isPassed(UploadedFileInterface $file): bool
    {
        $image = getimagesize($file->getStream()->getMetadata('uri'));
        if ($image[0] <= $this->width && $image[1] <= $this->height) {
            return true;
        }

        throw new ValidationException(sprintf('File dimensions are too big. Limit is %s by %s.', $this->width, $this->height));
    }

    public function getName(): string
    {
        return self::CHECKER_NAME;
    }
}