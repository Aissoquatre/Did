<?php

namespace Did\Routing\Params;

/**
 * Class DefaultParams
 *
 * @package (c) Did\Routing\Params
 */
class DefaultParams extends Params
{
    /** @var string Target the called Bundle-Module-Functionality */
    protected $module;

    /** @var string Target the action containaing class */
    protected $division;

    /** @var string Call the targeted action */
    protected $action;

    public function __construct(bool $fromGlobals = null, array $get = [], array $post = [], array $server = [])
    {
        parent::__construct($fromGlobals, $get, $post, $server);

        $this->fillAttributes();
    }

    /**
     * Add values to attributes
     */
    private function fillAttributes()
    {
        $this->module   = $this->get['module'];
        $this->division = $this->get['division'];
        $this->action   = $this->get['action'];
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getDivision(): string
    {
        return $this->division;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}