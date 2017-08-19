<?php

namespace webhelper\interfaces\routing;


use webhelper\errors\NotFoundException;

interface IRouter
{
    public function __construct(array $rules = []);

    /**
     * Set rule for default uri
     * @param IRule $rule
     * @return IRouter
     */
    public function setDefaultRule(IRule $rule): IRouter;

    /**
     * Set new routing rule
     * @param IRule $rule
     * @return IRouter
     */
    public function setRule(IRule $rule): IRouter;

    /**
     * @param string $uri
     * @param string $method
     * @return mixed
     */
    public function execute(string $uri, string $method);
}