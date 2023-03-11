<?php

namespace Didslm\FileUpload;

class File
{
    public const KB = 1;
    public const MB = 2;

    public const ALL_SIZES = [
        self::KB => 1000,
        self::MB => 1000000,
    ];

    //image types
    public const JPEG = 'image/jpeg';
    public const JPG = 'image/jpg';
    public const PNG = 'image/png';
    public const GIF = 'image/gif';

    public const IMAGES = [
        self::JPEG,
        self::JPG,
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

    //all video types
    public const MP4 = 'video/mp4';
    public const WEBM = 'video/webm';
    public const OGG = 'video/ogg';
    public const AVI = 'video/x-msvideo';
    public const WMV = 'video/x-ms-wmv';
    public const FLV = 'video/x-flv';
    public const MOV = 'video/quicktime';

    public const VIDEOS = [
        self::MP4,
        self::WEBM,
        self::OGG,
        self::AVI,
        self::WMV,
        self::FLV,
        self::MOV,
    ];

    public const ALL = [
        self::JPEG => 'jpg',
        self::JPG => 'jpg',
        self::PNG => 'png',
        self::GIF => 'gif',
        self::PDF => 'pdf',
        self::DOC => 'doc',
        self::DOCX => 'docx',
        self::XLS => 'xls',
        self::XLSX => 'xlsx',
        self::PPT => 'ppt',
        self::PPTX => 'pptx',
        self::MP4 => 'mp4',
        self::WEBM => 'webm',
        self::OGG => 'ogg',
        self::AVI => 'avi',
        self::WMV => 'wmv',
        self::FLV => 'flv',
        self::MOV => 'mov',
    ];

}