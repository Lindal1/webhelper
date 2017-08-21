<?php
/**
 * Created by PhpStorm.
 * User: lindal
 * Date: 21.08.17
 * Time: 18:28
 */

namespace webhelper;


use webhelper\interfaces\IUploadedFile;

class UploadedFile implements IUploadedFile
{

    private $_data;

    /**
     * IUploadedFile constructor.
     * @param array $data File data from request
     */
    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    /**
     * Return original filename
     * @return string
     */
    public function getName(): string
    {
        return $this->_data['name'];
    }

    /**
     * Return file size
     * @return int
     */
    public function getSize(): int
    {
        return (int)$this->_data['size'];
    }

    /**
     * Return file extension
     * @return string
     */
    public function getExtension(): string
    {
        return substr($this->getName(), mb_strripos($this->getName(), '.'));
    }

    /**
     * Return temp file path
     * @return string
     */
    public function getTmp(): string
    {
        return $this->_data['tmp_name'];
    }

    /**
     * Return file type
     * @return string
     */
    public function getType(): string
    {
        return $this->_data['type'];
    }
}