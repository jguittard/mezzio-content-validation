<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Validator;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface ValidatorHandlerInterface
 *
 * @package Mezzio\ContentValidation\Validator
 */
interface ValidatorHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return bool|ValidationResult
     */
    public function validate(ServerRequestInterface $request);
}
