<?php

namespace lindal\webhelper\interfaces\routing;

use lindal\webhelper\errors\NotFoundException;

interface IRouter
{

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