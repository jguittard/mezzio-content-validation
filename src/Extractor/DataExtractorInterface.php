<?php

/**
 * @see       https://github.com/jguittard/mezzio-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/mezzio-content-validation/blob/master/LICENSE.md
 *     MIT License
 */

declare(strict_types=1);

namespace Mezzio\ContentValidation\Extractor;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface DataExtractorInterface
 *
 * @package Mezzio\ContentValidation\Extractor
 */
interface DataExtractorInterface
{
    /**
     * Extract data from a PSR-7 request instance
     *
     * @param  ServerRequestInterface $request
     * @return mixed
     */
    public function extractData(ServerRequestInterface $request);
}
