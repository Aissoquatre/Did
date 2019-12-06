<?php

namespace Did\Routing;

use Did\Routing\Params\DefaultParams;
use Did\Routing\Params\Params;

/**
 * Class DefaultRoutingConfig
 *
 * @package Did\Routing
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class DefaultRoutingConfig implements RoutingConfigInterface
{
    /** @var string Namespace router should watch in */
    protected $namespace;

    /** @var string  */
    protected $suffix;

    /** @var string */
    protected $methodSuffix;

    public function __construct(string $namespace, string $suffix = '', string $methodSuffix = '')
    {
        $this->namespace    = $namespace;
        $this->suffix       = $suffix ?: 'Controller';
        $this->methodSuffix = $methodSuffix ?: 'Action';
    }

    /**
     * {@inheritdoc}
     */
    public function matchRoute(Params $params)
    {
        /** @var DefaultParams $params */

        $classname = $this->namespace . '\\' . ucfirst($params->getModule()) . '\\Controller\\' . ucfirst($params->getDivision()) . $this->suffix;

        if (!class_exists($classname)) {
            throw new \Exception('`' . $classname . '` is undefined');
        }

        $class = new $classname($params);

        $method = $params->getAction() . $this->methodSuffix;

        if (!method_exists($class, $method)) {
            throw new \Exception('`' . $method . '` doesn\'t match any method in `' . $classname . '`.');
        }

        $getParams = $params->getGet();

        unset($getParams['module'], $getParams['division'], $getParams['action']);

        $this->return(call_user_func_array([$class, $method], $getParams));
    }

    /**
     * @param mixed $action
     */
    private function return($action)
    {
        echo $action;
    }
}