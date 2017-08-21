<?php

namespace lindal\webhelper;

use lindal\webhelper\interfaces\IHeaderCollection;

class HeaderCollection implements IHeaderCollection
{

    private $_headers = [];

    /**
     * Add header to collection
     * @param string $name
     * @param string $value
     * @return IHeaderCollection
     */
    public function add(string $name, string $value): IHeaderCollection
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    /**
     * Return header value by name or null if header doesn't exist
     * @param string $name Header name
     * @return mixed
     */
    public function get(string $name): mixed
    {
        return $this->_headers[$name] ?? null;
    }

    /**
     * Return all headers
     * @return array
     */
    public function getList(): array
    {
        return $this->_headers;
    }

    /**
     * Set new or replace exists header
     * @param string $name
     * @param string $value
     * @return IHeaderCollection
     */
    public function set(string $name, string $value): IHeaderCollection
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    /**
     * Clear all data from collection
     * @return IHeaderCollection
     */
    public function clear(): IHeaderCollection
    {
        $this->_headers = [];
    }
}