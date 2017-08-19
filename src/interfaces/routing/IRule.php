<?php

namespace webhelper\interfaces\routing;


interface IRule
{

    public function __construct(string $class, string $handler, string $pattern, string $method = 'GET');

    public function match(string $uri, string $method);

    public function getClass(): string;

    public function getHandler(): string;

}