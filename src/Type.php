<?php

namespace Didslm\FileUpload;

class Type
{

    //image types
    public const JPEG = 'image/jpeg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const IMAGES = [
        self::JPEG,
        self::PNG,
        self::GIF,
    ];

    //document types
    public const PDF = 'application/pdf';
    public const DOC = 'application/msword';
    public const DOCX = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    public const XLS = 'application/vnd.ms-excel';
    public const XLSX = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    public const PPT = 'application/vnd.ms-powerpoint';
    public const PPTX = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';

    public const DOCUMENTS = [
        self::PDF,
        self::DOC,
        self::DOCX,
        self::XLS,
        self::XLSX,
        self::PPT,
        self::PPTX,
    ];

    public const ALL = [
        self::JPEG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
        self::PDF => 'pdf',
        self::DOC => 'doc',
        self::DOCX => 'docx',
        self::XLS => 'xls',
        self::XLSX => 'xlsx',
        self::PPT => 'ppt',
        self::PPTX => 'pptx',
    ];

}