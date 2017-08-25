<?php

namespace lindal\webhelper\routing;

use lindal\webhelper\errors\NotFoundException;
use lindal\webhelper\interfaces\IRequest;
use lindal\webhelper\interfaces\IResponse;
use lindal\webhelper\interfaces\routing\IRouter;
use lindal\webhelper\interfaces\routing\IRule;

class Router implements IRouter
{

    /**
     * @var IRequest
     */
    private $_request;

    /**
     * @var IResponse
     */
    private $_response;

    /**
     * @var IRule[]
     */
    private $_rules = [];

    /**
     * Router constructor.
     * @param IRequest $request
     * @param IResponse $response
     * @param IRule[] $rules
     */
    public function __construct(IRequest $request, IResponse $response, array $rules = [])
    {
        $this->_request = $request;
        $this->_response = $response;
        $this->_rules = $rules;
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
                $class = new $rule->getClass();
                call_user_func([$class, $rule->getHandler()], $this->_request, $this->_response, $params);
                return;
            }
        }
        throw new NotFoundException();
    }
}