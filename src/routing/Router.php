<?php

namespace lindal\webhelper\routing;

use lindal\webhelper\errors\NotFoundException;
use lindal\webhelper\interfaces\IRequest;
use lindal\webhelper\interfaces\routing\IRouter;
use lindal\webhelper\interfaces\routing\IRule;

/**
 * Created by PhpStorm.
 * User: lindal
 * Date: 21.08.17
 * Time: 18:38
 */
class Router implements IRouter
{

    /**
     * @var IRequest
     */
    private $_request;

    /**
     * @var IRule[]
     */
    private $_rules = [];

    /**
     * @var IRule
     */
    private $_defaultRule;

    /**
     * Router constructor.
     * @param IRule[] $rules
     * @param IRequest $request
     */
    public function __construct(array $rules = [], IRequest $request)
    {
        $this->_request = $request;
        $this->_rules = $rules;
    }

    /**
     * Set rule for default uri
     * @param IRule $rule
     * @return IRouter
     */
    public function setDefaultRule(IRule $rule): IRouter
    {
        $this->_defaultRule = $rule;
        return $this;
    }

    /**
     * Set new routing rule
     * @param IRule $rule
     * @return IRouter
     */
    public function addRule(IRule $rule): IRouter
    {
        $this->_rules[] = $rule;
        return $this;
    }

    /**
     * @throws NotFoundException
     * @return mixed
     */
    public function execute()
    {
        foreach ($this->_rules as $rule) {
            if ($rule->getMethod() != $this->_request->getMethod()) {
                continue;
            }
            if ($this->match($this->_request->getUri(), $this->_request->getMethod())) {
                $params = $rule->extractParams($this->_request->getUri());
                foreach ((array)$params as $name => $value) {
                    $this->_request->setGetParam($name, $value);
                }
                $class = new ($rule->getClass());
                call_user_func([$class, $rule->getHandler()]);
                return;
            }
        }
        throw new NotFoundException();
    }
}