<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\ContentValidation\Validator\ValidationResult;
use Zend\Expressive\ContentValidation\Validator\ValidatorHandler;
use Zend\ProblemDetails\ProblemDetailsResponseFactory;

/**
 * Class ValidationMiddleware
 *
 * @package Zend\Expressive\ContentValidation\Middleware
 */
class ValidationMiddleware implements MiddlewareInterface
{
    /**
     * @var ValidatorHandler
     */
    private $validator;

    /**
     * @var ProblemDetailsResponseFactory
     */
    private $problemDetailsFactory;

    /**
     * ValidationMiddleware constructor.
     *
     * @param ValidatorHandler $validator
     * @param ProblemDetailsResponseFactory $problemDetailsFactory
     */
    public function __construct(ValidatorHandler $validator, ProblemDetailsResponseFactory $problemDetailsFactory)
    {
        $this->validator = $validator;
        $this->problemDetailsFactory = $problemDetailsFactory;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var ValidationResult $validationResult
         */
        $validationResult = $this->validator->validate($request);

        if ($validationResult instanceof ValidationResult && ! $validationResult->isValid()) {
            return $this->problemDetailsFactory->createResponse(
                $request,
                422,
                'Failed Validation',
                '',
                '',
                ['errors' => $validationResult->getMessages()]
            );
        }

        if ($validationResult instanceof ValidationResult) {
            $request = $request->withParsedBody($validationResult->getValues());
        }

        return $handler->handle($request);
    }
}
