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
use Mezzio\Router\RouterInterface;

/**
 * Class ParamsExtractor
 *
 * @package Mezzio\ContentValidation\Extractor
 */
class ParamsExtractor implements DataExtractorInterface
{
    /**
     * @var RouterInterface $route
     */
    private $router;

    /**
     * ParamsExtractor constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function extractData(ServerRequestInterface $request)
    {
        $routeResult = $this->router->match($request);

        return $routeResult->getMatchedParams();
    }
}
