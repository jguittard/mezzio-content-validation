<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation;

/**
 * Class ConfigProvider
 *
 * @package Mezzio\ContentValidation
 */
class ConfigProvider
{
    /**
     * Return configuration for this component.
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency mappings for this component.
     *
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                Middleware\ValidationMiddleware::class => Middleware\ValidationMiddlewareFactory::class,
                Validator\ValidatorHandler::class => Validator\ValidatorHandlerFactory::class,
                Extractor\OptionsExtractor::class => Extractor\OptionsExtractorFactory::class,
                Extractor\ParamsExtractor::class => Extractor\ParamsExtractorFactory::class,
                Extractor\DataExtractorChain::class => Extractor\DataExtractorChainFactory::class,
            ],
        ];
    }
}
