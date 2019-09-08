<?php

namespace Did\Routing;

use Did\Routing\Params\Params;

/**
 * Interface RoutingConfigInterface
 *
 * @package Did\Routing
 * @author Julien Bernard <hello@julien-bernard.com>
 */
interface RoutingConfigInterface
{
    /**
     * @param Params $params
     * @return mixed
     */
    public function matchRoute(Params $params);
}