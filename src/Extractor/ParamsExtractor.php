<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Extractor;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class ParamsExtractor
 *
 * @package Zend\Expressive\ContentValidation\Extractor
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
