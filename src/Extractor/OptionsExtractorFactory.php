<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Extractor;

use Psr\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;

/**
 * Class OptionsExtractorFactory
 *
 * @package Mezzio\ContentValidation\Extractor
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
