<?php

namespace webhelper\interfaces\routing;


use webhelper\errors\NotFoundException;
use webhelper\interfaces\IRequest;

interface IRouter
{
    /**
     * IRouter constructor.
     * @param IRule[] $rules
     * @param IRequest $request
     */
    public function __construct(array $rules = [], IRequest $request);

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
    public function addRule(IRule $rule): IRouter;

    /**
     * @throws NotFoundException
     * @return mixed
     */
    public function execute();
}