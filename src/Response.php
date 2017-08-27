<?php
/**
 * Created by PhpStorm.
 * User: lindal
 * Date: 21.08.17
 * Time: 18:16
 */

namespace lindal\webhelper;


use lindal\webhelper\interfaces\IHeaderCollection;
use lindal\webhelper\interfaces\IResponse;

class Response implements IResponse
{

    private static $_instance;
    private $_headers;
    private $_body;
    private $_code = 200;
    private $_statusText = 'OK';
    private $_cookies = [];

    /**
     * Return singleton instance
     * @return IResponse
     */
    public static function getInstance(): IResponse
    {
        if (!self::$_instance) {
            self::$_instance = new Response();
        }
        return self::$_instance;
    }

    /**
     * Return response headers
     * @return IHeaderCollection
     */
    public function getHeaders(): IHeaderCollection
    {
        if (!$this->_headers) {
            $this->_headers = new HeaderCollection();
        }
        return $this->_headers;
    }

    /**
     * Set headers to response
     * @param IHeaderCollection $collection
     * @return IResponse
     */
    public function setHeaders(IHeaderCollection $collection): IResponse
    {
        $this->_headers = $collection;
        return $this;
    }

    /**
     * Set body to response
     * @param string $body Response body
     * @return IResponse
     */
    public function setBody(string $body): IResponse
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Return response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->_body;
    }

    /**
     * Send response to user
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendCookies();
        echo $this->_body;
    }

    /**
     * Set status code to response
     * @param int $code
     * @return IResponse
     */
    public function setCode(int $code): IResponse
    {
        $this->_code = $code;
        return $this;
    }

    /**
     * Return response status code
     * @return int
     */
    public function getCode(): int
    {
        return $this->_code;
    }

    /**
     * Sends the response headers to the client.
     */
    protected function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }
        $statusCode = $this->getCode();
        header("HTTP/1.1 {$statusCode} {$this->_statusText}");
        if ($this->_headers) {
            $headers = $this->getHeaders();
            foreach ($headers as $name => $values) {
                $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
                // set replace for first occurrence of header but false afterwards to allow multiple
                $replace = true;
                foreach ($values as $value) {
                    header("$name: $value", $replace);
                    $replace = false;
                }
            }
        }
        $this->sendCookies();
    }

    /**
     * Sends the cookies to the client.
     */
    protected function sendCookies()
    {
        if ($this->_cookies === null) {
            return;
        }
        foreach ($this->getCookies() as $name => $cookie) {
            $value = $cookie['value'];
            setcookie($name, $value, $cookie['expire'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httpOnly']);
        }
    }

    /**
     * Redirect to url
     * @param string $url
     * @return null
     */
    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->getStatusText();
    }

    /**
     * @param string $text
     * @return IResponse
     */
    public function setStatusText(string $text): IResponse
    {
        $this->_statusText = $text;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return IResponse
     */
    public function setCookies(string $name, string $value, $expire = null, $path = null, $domain = null, bool $secure = false, bool $httpOnly = true): IResponse
    {
        $this->_cookies[$name] = [
            'value' => $value,
            'expire' => $expire,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        ];
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->_cookies;
    }
}