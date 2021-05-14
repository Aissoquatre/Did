<?php

namespace Did\Kernel;

/**
 * Class AbstractController
 *
 * @package Did\Controller
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Environment
{
    /**
     * @var Environment
     */
    private static $instance = null;

    /**
     * @var array
     */
    private $vars = [];

    /**
     * Environment constructor.
     */
    private function __construct() {}

    /**
     * @return Environment
     */
    public static function get(): Environment
    {
        if (!self::$instance) {
            self::$instance = new Environment();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function vars(): array
    {
        return $this->vars;
    }

    /**
     * Set application environnement variables.
     *
     * @param array $vars
     *
     * @return Environment
     */
    public function setVars(array $vars) : Environment
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * Smart method that will check in const if not found in vars attribute.
     *
     * @param string $varName
     *
     * @return mixed
     */
    public function findVar(string $varName)
    {
        if (!isset($this->vars()[$varName])) {
            $var = defined($varName) ? constant($varName) : null;
        } else {
            $var = $this->vars()[$varName];
        }

        return $var;
    }
}
