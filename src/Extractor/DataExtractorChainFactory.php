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

/**
 * Class DataExtractorChainFactory
 *
 * @package Zend\Expressive\ContentValidation\Extractor
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
