<?php

namespace webhelper\interfaces;


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
    public function send(): void;

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
}