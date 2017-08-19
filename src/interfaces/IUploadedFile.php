<?php

namespace webhelper\interfaces;


interface IUploadedFile
{

    /**
     * IUploadedFile constructor.
     * @param array $data File data from request
     */
    public function __construct(array $data);

    /**
     * Return original filename
     * @return string
     */
    public function getName(): string;

    /**
     * Return file size
     * @return int
     */
    public function getSize(): int;

    /**
     * Return file extension
     * @return string
     */
    public function getExtension(): string;

    /**
     * Return temp file path
     * @return string
     */
    public function getTmp(): string;

}