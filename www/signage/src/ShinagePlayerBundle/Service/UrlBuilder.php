<?php

namespace mztx\ShinagePlayerBundle\Service;

class UrlBuilder
{
    /** @var string  */
    protected $protocol = '';

    /** @var string  */
    protected $host = '';

    /** @var string  */
    protected $basePath = '';

    /** @var array  */
    protected $controllers = [];

    /**
     * UrlBuilder constructor.
     *
     * @param string $protocol
     * @param string $host
     * @param string $basePath
     * @param array  $controllers
     */
    public function __construct($protocol, $host, $basePath, array $controllers)
    {
        $this->protocol = $protocol;
        $this->host = $host;
        $this->basePath = $basePath;
        $this->controllers = $controllers;
    }


    /**
     * Returns the configured URL for the given controller and inserts parameters if needed.
     *
     * @param string $controller
     * @param array  ...$args
     *
     * @return string
     * @throws \Exception
     */
    public function getControllerUrl($controller, ...$args)
    {
        if (!isset($this->controllers[$controller])) {
            throw new \Exception('No URL for given controller configured.');
        }
        return $this->concat(
            $this->concat(
                $this->protocol . '://' . $this->host,
                $this->basePath
            ),
            vsprintf($this->controllers[$controller], $args)
        );
    }

    /**
     * Concats two URL parts and assures that they are glued by exactly *one* slash.
     * @param string $left
     * @param string $right
     *
     * @return string
     */
    public function concat($left, $right)
    {
        return rtrim($left, '/') . '/' . ltrim($right, '/');
    }
}
