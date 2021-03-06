<?php

namespace lindal\webhelper;

use lindal\webhelper\interfaces\IHeaderCollection;
use lindal\webhelper\interfaces\IRequest;

class Request implements IRequest
{

    private static $_instance;
    private $_get = [];
    private $_post = [];
    private $_headers;

    /**
     * Return singleton instance
     * @return IRequest
     */
    public static function getInstance(): IRequest
    {
        if (!self::$_instance) {
            self::$_instance = new Request();
        }
        return self::$_instance;
    }

    /**
     * Return request method
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return GET param by name
     * @param string|null $name
     * @param mixed $default Return this value if param doesn't exist
     * @return mixed
     */
    public function get($name = null, $default = null)
    {
        $params = array_merge($_GET, $this->_get);
        if (!$name) {
            return $params;
        }
        return $params[$name] ?? $default;
    }

    /**
     * Set GET param to request
     * @param string $name
     * @param string $value
     * @return IRequest
     */
    public function setGetParam(string $name, string $value): IRequest
    {
        $this->_get[$name] = $value;
        return $this;
    }

    /**
     * Set POST PARAM to request
     * @param string $name
     * @param string $value
     * @return IRequest
     */
    public function setPostParam(string $name, string $value): IRequest
    {
        $this->_post[$name] = $value;
    }

    /**
     * Return POST param by name
     * @param string|null $name
     * @param mixed|null $default Return this value if param doesn't exist
     * @return mixed
     */
    public function post($name = null, $default = null)
    {
        $params = array_merge($_POST, $this->_post);
        if (!$name) {
            return $params;
        }
        return $params[$name] ?? $default;
    }

    /**
     * Return request headers
     * @return IHeaderCollection
     */
    public function getHeaders(): IHeaderCollection
    {
        if ($this->_headers === null) {
            $this->_headers = new HeaderCollection();
            if (function_exists('getallheaders')) {
                $headers = getallheaders();
                foreach ($headers as $name => $value) {
                    $this->_headers->add($name, $value);
                }
            } elseif (function_exists('http_get_request_headers')) {
                $headers = http_get_request_headers();
                foreach ($headers as $name => $value) {
                    $this->_headers->add($name, $value);
                }
            } else {
                foreach ($_SERVER as $name => $value) {
                    if (strncmp($name, 'HTTP_', 5) === 0) {
                        $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                        $this->_headers->add($name, $value);
                    }
                }
            }
        }
        return $this->_headers;
    }

    /**
     * Return uploaded files
     * @return array
     */
    public function getUploadedFiles(): array
    {
        $result = [];
        foreach ($_FILES as $name => $data) {
            if (is_array($data['name'])) {
                foreach ($this->diverseArray($data) as $file) {
                    if ($file['name'] && $file['tmp_name'] && $file['size']) {
                        $result[$name][] = new UploadedFile($file);
                    }
                }
            } else {
                if ($data['name'] && $data['tmp_name'] && $data['size']) {
                    $result[$name] = new UploadedFile($data);
                }
            }
        }
        return $result;
    }

    /**
     * @param $vector
     * @return array
     */
    private function diverseArray($vector)
    {
        $result = [];
        foreach ($vector as $key1 => $value1)
            foreach ($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;
        return $result;
    }

    /**
     * Check is GET request
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    /**
     * Check is POST request
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() == 'POST';
    }

    /**
     * Check is PUT request
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->getMethod() == 'PUT';
    }

    /**
     * Check is DELETE request
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->getMethod() == 'DELETE';
    }

    /**
     * Check is OPTION request
     * @return bool
     */
    public function isOption(): bool
    {
        return $this->getMethod() == 'OPTION';
    }

    /**
     * Return request URL
     * @return string
     */
    public function getUrl(): string
    {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * Return request URI
     * @return string
     */
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}