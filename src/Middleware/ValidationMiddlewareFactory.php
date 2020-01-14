<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Middleware;

use Psr\Container\ContainerInterface;
use Mezzio\ContentValidation\Validator\ValidatorHandler;
use Mezzio\ProblemDetails\ProblemDetailsResponseFactory;

/**
 * Class ValidationMiddlewareFactory
 *
 * @package Mezzio\ContentValidation\Middleware
 */
class ValidationMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return ValidationMiddleware
     */
    public function __invoke(ContainerInterface $container): ValidationMiddleware
    {
        return new ValidationMiddleware(
            $container->get(ValidatorHandler::class),
            $container->get(ProblemDetailsResponseFactory::class)
        );
    }
}
