<?php

namespace lindal\webhelper\interfaces;

interface IRequest
{

    /**
     * Return singleton instance
     * @return IRequest
     */
    public static function getInstance(): IRequest;

    /**
     * Return request method
     * @return string
     */
    public function getMethod(): string;

    /**
     * Return GET param by name
     * @param string $name
     * @param mixed|null $default Return this value if param doesn't exist
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed;

    /**
     * Set GET param to request
     * @param string $name
     * @param string $value
     * @return IRequest
     */
    public function setGetParam(string $name, string $value): IRequest;

    /**
     * Set POST PARAM to request
     * @param string $name
     * @param string $value
     * @return IRequest
     */
    public function setPostParam(string $name, string $value): IRequest;

    /**
     * Return POST param by name
     * @param string $name
     * @param mixed|null $default Return this value if param doesn't exist
     * @return mixed
     */
    public function post(string $name, mixed $default = null): mixed;

    /**
     * Return request headers
     * @return IHeaderCollection
     */
    public function getHeaders(): IHeaderCollection;

    /**
     * Return uploaded files
     * @return IUploadedFile[]
     */
    public function getUploadedFiles(): array;

    /**
     * Check is GET request
     * @return bool
     */
    public function isGet(): bool;

    /**
     * Check is POST request
     * @return bool
     */
    public function isPost(): bool;

    /**
     * Check is PUT request
     * @return bool
     */
    public function isPut(): bool;

    /**
     * Check is DELETE request
     * @return bool
     */
    public function isDelete(): bool;

    /**
     * Check is OPTION request
     * @return bool
     */
    public function isOption(): bool;

    /**
     * Return request URL
     * @return string
     */
    public function getUrl(): string;

    /**
     * Return request URI
     * @return string
     */
    public function getUri(): string;

}