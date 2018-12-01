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
 * Class OptionsExtractorFactory
 *
 * @package Zend\Expressive\ContentValidation\Extractor
 */
class OptionsExtractorFactory
{
    public function __invoke(ContainerInterface $container): OptionsExtractor
    {
        $validationConfig = $container->get('config')['content-validation'] ?? [];

        return new OptionsExtractor(
            $validationConfig,
            $container->get(
                RouterInterface::class
            )
        );
    }
}
