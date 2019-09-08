<?php

namespace Did\Routing\Params;

/**
 * Interface ParamsInterface
 *
 * @package Did\Routing\Params
 *
 */
interface ParamsInterface
{
    /**
     * ParamsInterface constructor.
     *
     * @param bool|null $fromGlobals
     * @param array $get
     * @param array $post
     * @param array $server
     */
    public function __construct(bool $fromGlobals = null, array $get = [], array $post = [], array $server = []);

    /**
     * Create and hydrate Params object
     *
     * @return ParamsInterface
     */
    public function createFromGlobals();
}