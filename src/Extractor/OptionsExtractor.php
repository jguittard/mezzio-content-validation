<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Extractor;

use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Router\RouteResult;
use Mezzio\Router\RouterInterface;

/**
 * Class OptionsExtractor
 *
 * @package Mezzio\ContentValidation\Extractor
 */
class OptionsExtractor
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var RouterInterface $route
     */
    private $router;

    /**
     * OptionsExtractor constructor.
     *
     * @param array $config
     * @param RouterInterface $router
     */
    public function __construct(array $config, RouterInterface $router)
    {
        $this->config = $config;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    public function getOptionsForRequest(ServerRequestInterface $request)
    {
        /**
         * @var RouteResult $routeMatch
         */
        $matchedRoute = $this->router->match($request)->getMatchedRoute();

        foreach ($this->config as $routeName => $options) {
            if ($routeName === $matchedRoute->getName()) {
                return isset($options) ? $options : [];
            }
        }

        return [];
    }
}
