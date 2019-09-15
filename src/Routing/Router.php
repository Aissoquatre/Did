<?php

namespace Did\Routing;

use Did\Kernel\Environment;
use Did\Routing\Params\DefaultParams;
use Did\Routing\Params\ParamsInterface;

/**
 * Class Router
 *
 * @package Did\Routing
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Router
{
    /** @var RoutingConfigInterface Routing default config */
    protected $config;

    /** @var RoutingConfigInterface Overload routing default config */
    protected $configOverload;

    /** @var ParamsInterface Routing default config */
    protected $params;

    /** @var ParamsInterface Overload routing default params */
    protected $paramsOverload;

    /**
     * Router constructor.
     *
     * @param RoutingConfigInterface|null $config
     * @param ParamsInterface|null $params
     */
    public function __construct(?RoutingConfigInterface $config = null, ?ParamsInterface $params = null)
    {
        $this->config = $config ?: new DefaultRoutingConfig(Environment::get()->findVar('APP_NAMESPACE'));
        $this->params = $params ?: new DefaultParams(true);
    }

    public function findRoute()
    {
        try {
            $config = $this->configOverload ?: $this->config;
            $params = $this->paramsOverload ?: $this->params;

            $config->matchRoute($params);
        } catch(\Exception $e) {
            if (Environment::get()->findVar('APP_ENV') === 'dev') {
                Catcher::devCatch($e);
            }
        }
    }

    /**
     * @return RoutingConfigInterface
     */
    public function getConfig(): RoutingConfigInterface
    {
        return $this->configOverload ?: $this->config;
    }

    /**
     * Overload the default config setted on initialization
     *
     * @param RoutingConfigInterface $configOverloaded
     * @return Router
     */
    public function setConfig(RoutingConfigInterface $configOverloaded): Router
    {
        $this->configOverload = $configOverloaded;
        return $this;
    }

    /**
     * @return ParamsInterface
     */
    public function getParams(): ParamsInterface
    {
        return $this->paramsOverload ?: $this->params;
    }

    /**
     * Overload the default params setted on initialization
     *
     * @param ParamsInterface $paramsOverloaded
     * @return Router
     */
    public function setParams(ParamsInterface $paramsOverloaded): Router
    {
        $this->paramsOverload = $paramsOverloaded;
        return $this;
    }
}