<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Validator;

use Psr\Container\ContainerInterface;
use Mezzio\ContentValidation\Extractor\DataExtractorChain;
use Mezzio\ContentValidation\Extractor\OptionsExtractor;

/**
 * Class ValidatorHandlerFactory
 *
 * @package Mezzio\ContentValidation\Validator
 */
class ValidatorHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ValidatorHandler
     */
    public function __invoke(ContainerInterface $container): ValidatorHandler
    {
        return new ValidatorHandler(
            $container->get(OptionsExtractor::class),
            $container->get(DataExtractorChain::class),
            $container->get('InputFilterManager')
        );
    }
}
