<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Validator;

use Psr\Container\ContainerInterface;
use Zend\Expressive\ContentValidation\Extractor\DataExtractorChain;
use Zend\Expressive\ContentValidation\Extractor\OptionsExtractor;

/**
 * Class ValidatorHandlerFactory
 *
 * @package Zend\Expressive\ContentValidation\Validator
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
