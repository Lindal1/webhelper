<?php

namespace lindal\webhelper\routing;

use lindal\webhelper\interfaces\routing\IRule;

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

    /**
     * @inheritdoc
     */
    public function match(string $uri)
    {
        $regexp = preg_replace('/{[a-z]+}/', '[^/]+', $this->_pattern);
        $regexp = str_replace('/', '\/', $regexp);
        return (bool)preg_match('/' . $regexp . '$/', $uri);
    }

    /**
     * @inheritdoc
     */
    public function getClass(): string
    {
        return $this->_class;
    }

    /**
     * @inheritdoc
     */
    public function getHandler(): string
    {
        return $this->_handler;
    }

    /**
     * @inheritdoc
     */
    public function extractParams(string $uri): array
    {
        $keyRegexp = preg_replace('/{[a-z]+}/', '{(.+)}', $this->_pattern);
        $keyRegexp = str_replace('/', '\/', $keyRegexp);
        preg_match('/' . $keyRegexp . '/', $this->_pattern, $keys);
        $valueRegexp = preg_replace('/{[a-z]+}/', '([^/]+)', $this->_pattern);
        $valueRegexp = str_replace('/', '\/', $valueRegexp);
        preg_match('/' . $valueRegexp . '/', $uri, $values);
        $result = [];
        foreach ($keys as $key => $value) {
            if ($key == 0) {
                continue;
            }
            $result[$value] = $values[$key];
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->_method;
    }
}