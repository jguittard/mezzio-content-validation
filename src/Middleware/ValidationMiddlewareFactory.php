<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Expressive\ContentValidation\Validator\ValidatorHandler;
use Zend\ProblemDetails\ProblemDetailsResponseFactory;

/**
 * Class ValidationMiddlewareFactory
 *
 * @package Zend\Expressive\ContentValidation\Middleware
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
