<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Validator;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface ValidatorHandlerInterface
 *
 * @package Zend\Expressive\ContentValidation\Validator
 */
interface ValidatorHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return bool|ValidationResult
     */
    public function validate(ServerRequestInterface $request);
}
