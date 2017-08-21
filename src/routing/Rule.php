<?php
/**
 * Created by PhpStorm.
 * User: lindal
 * Date: 21.08.17
 * Time: 19:07
 */

namespace webhelper\routing;


use webhelper\interfaces\routing\IRule;

class Rule implements IRule
{

    private $_class;
    private $_handler;
    private $_pattern;
    private $_method;

    /**
     * Rule constructor.
     * @param string $class
     * @param string $handler
     * @param string $pattern
     * @param string $method
     */
    public function __construct(string $class, string $handler, string $pattern, string $method = 'GET')
    {
        $this->_class = $class;
        $this->_handler = $handler;
        $this->_pattern = $pattern;
        $this->_method = $method;
    }

    public function match(string $uri, string $method)
    {
        $regexp = preg_replace('/{.*}/', '.+', $this->_pattern);

    }

    public function getClass(): string
    {
        return $this->_class;
    }

    public function getHandler(): string
    {
        return $this->_handler;
    }

    public function extractParams(string $uri): array
    {

    }
}