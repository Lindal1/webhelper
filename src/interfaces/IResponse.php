<?php

namespace lindal\webhelper\interfaces;

interface IResponse
{

    /**
     * Return singleton instance
     * @return IResponse
     */
    public static function getInstance(): IResponse;

    /**
     * Return response headers
     * @return IHeaderCollection
     */
    public function getHeaders(): IHeaderCollection;

    /**
     * Set headers to response
     * @param IHeaderCollection $collection
     * @return IResponse
     */
    public function setHeaders(IHeaderCollection $collection): IResponse;

    /**
     * Set body to response
     * @param string $body Response body
     * @return IResponse
     */
    public function setBody(string $body): IResponse;

    /**
     * Return response body
     * @return string
     */
    public function getBody(): string;

    /**
     * Send response to user
     */
    public function send();

    /**
     * Set status code to response
     * @param int $code
     * @return IResponse
     */
    public function setCode(int $code): IResponse;

    /**
     * Return response status code
     * @return int
     */
    public function getCode(): int;

    /**
     * Redirect to url
     * @param string $url
     * @return null
     */
    public function redirect(string $url);

    /**
     * @return string
     */
    public function getStatusText(): string;

    /**
     * @param string $text
     * @return IResponse
     */
    public function setStatusText(string $text): IResponse;

    /**
     * @param string $name
     * @param string $value
     * @param null $expire
     * @param null $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return IResponse
     */
    public function setCookies(string $name, string $value, $expire = null, $path = null, $domain = null, bool $secure = false, bool $httpOnly = true): IResponse;

    /**
     * @return array
     */
    public function getCookies(): array;
}