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

/**
 * Class DataExtractorChainFactory
 *
 * @package Mezzio\ContentValidation\Extractor
 */
class DataExtractorChainFactory
{
    /**
     * @param ContainerInterface $container
     * @return DataExtractorChain
     */
    public function __invoke(ContainerInterface $container): DataExtractorChain
    {
        $extractors = [
            new QueryExtractor(),
            new BodyExtractor(),
            new FileExtractor(),
            $container->get(ParamsExtractor::class)
        ];

        return new DataExtractorChain($extractors);
    }
}
