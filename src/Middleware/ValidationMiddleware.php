<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Middleware;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\ContentValidation\Validator\ValidationResult;
use Mezzio\ContentValidation\Validator\ValidatorHandler;
use Mezzio\ProblemDetails\ProblemDetailsResponseFactory;

/**
 * Class ValidationMiddleware
 *
 * @package Mezzio\ContentValidation\Middleware
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
                ['messages' => $validationResult->getMessages()]
            );
        }

        if ($validationResult instanceof ValidationResult) {
            $values = $validationResult->getValues();
            if ($request->getMethod() === RequestMethodInterface::METHOD_GET) {
                $query = $request->getQueryParams();
                $params = array_intersect_key($values, $query);
                $request = $request->withQueryParams($params);
            } elseif (
                in_array(
                    $request->getMethod(),
                    [
                        RequestMethodInterface::METHOD_POST,
                        RequestMethodInterface::METHOD_PUT,
                        RequestMethodInterface::METHOD_PATCH
                    ]
                )
            ) {
                $body = $request->getParsedBody();
                $data = array_intersect_key($values, $body);
                $request = $request->withParsedBody($data);
            }
        }

        return $handler->handle($request);
    }
}
