<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Validator;

/**
 * Interface ValidationResultInterface
 *
 * @package Mezzio\ContentValidation\Validator
 */
interface ValidationResultInterface
{
    /**
     * Check if the validation was successful
     *
     * If there are no validation messages set, the validation result object is considered valid.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Get validation messages
     *
     * @return array
     */
    public function getMessages(): array;

    /**
     * Get the raw input values
     *
     * @return array
     */
    public function getRawValues(): array;

    /**
     * Get the filtered input values
     *
     * @return array
     */
    public function getValues(): array;
}
