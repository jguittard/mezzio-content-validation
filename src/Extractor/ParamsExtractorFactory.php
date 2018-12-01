<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Extractor;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class ParamsExtractorFactory
 *
 * @package Zend\Expressive\ContentValidation\Extractor
 */
class ParamsExtractorFactory
{
    /**
     * @param ContainerInterface $container
     * @return ParamsExtractor
     */
    public function __invoke(ContainerInterface $container): ParamsExtractor
    {
        return new ParamsExtractor($container->get(RouterInterface::class));
    }
}
