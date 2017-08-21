<?php

namespace lindal\webhelper\interfaces\routing;


interface IRule
{

    /**
     * IRule constructor.
     * @param string $class
     * @param string $handler
     * @param string $pattern
     * @param string $method
     */
    public function __construct(string $class, string $handler, string $pattern, string $method = 'GET');

    /**
     * @param string $uri
     * @return mixed
     */
    public function match(string $uri);

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getHandler(): string;

    /**
     * @param string $uri
     * @return array
     */
    public function extractParams(string $uri): array;

    /**
     * @return string
     */
    public function getMethod(): string;
}