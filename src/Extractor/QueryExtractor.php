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
 * Class QueryExtractor
 *
 * @package Mezzio\ContentValidation\Extractor
 */
class QueryExtractor implements DataExtractorInterface
{
    /**
     * @inheritDoc
     */
    public function extractData(ServerRequestInterface $request)
    {
        return $request->getQueryParams();
    }
}
