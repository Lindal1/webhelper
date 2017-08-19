<?php

namespace webhelper\interfaces;

interface IHeaderCollection
{

    /**
     * IHeaderCollection constructor.
     * @param array $headers
     */
    public function __construct(array $headers);

    /**
     * Return header value by name or null if header doesn't exist
     * @param string $name Header name
     * @return mixed
     */
    public function get(string $name): mixed;

    /**
     * Return all headers
     * @return array
     */
    public function getList(): array;

    /**
     * Set new or replace exists header
     * @param string $name
     * @param string $value
     * @return IHeaderCollection
     */
    public function set(string $name, string $value): IHeaderCollection;

    /**
     * Clear all data from collection
     * @return IHeaderCollection
     */
    public function clear(): IHeaderCollection;

}