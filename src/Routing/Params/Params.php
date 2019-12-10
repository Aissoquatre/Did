<?php

namespace Did\Routing\Params;

/**
 * Class Params
 *
 * @package Did\Routing\Params
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
abstract class Params implements ParamsInterface
{
    /** @var array */
    protected $get;

    /** @var array */
    protected $post;

    /** @var array */
    protected $server;

    /** @var null|array */
    protected $json;

    /**
     * {@inheritdoc}
     */
    public function __construct(bool $fromGlobals = null, array $get = [], array $post = [], array $server = [])
    {
        if (!$fromGlobals) {
            $this->get    = $get;
            $this->post   = $post;
            $this->server = $server;
        } else {
            $this->createFromGlobals();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createFromGlobals()
    {
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->server = $_SERVER;
        $this->json   = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    /**
     * @return null|array
     */
    public function getJson(): ?array
    {
        return $this->json;
    }
}