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
    private $statusText = 'OK';

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
        header("HTTP/1.1 {$statusCode} {$this->statusText}");
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
        $request = Yii::$app->getRequest();
        if ($request->enableCookieValidation) {
            if ($request->cookieValidationKey == '') {
                throw new InvalidConfigException(get_class($request) . '::cookieValidationKey must be configured with a secret key.');
            }
            $validationKey = $request->cookieValidationKey;
        }
        foreach ($this->getCookies() as $cookie) {
            $value = $cookie->value;
            if ($cookie->expire != 1 && isset($validationKey)) {
                $value = Yii::$app->getSecurity()->hashData(serialize([$cookie->name, $value]), $validationKey);
            }
            setcookie($cookie->name, $value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httpOnly);
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
        $this->statusText = $text;
        return $this;
    }
}