<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Extractor;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BodyExtractor
 *
 * @package Zend\Expressive\ContentValidation\Extractor
 */
class BodyExtractor implements DataExtractorInterface
{
    /**
     * @inheritDoc
     */
    public function extractData(ServerRequestInterface $request)
    {
        return $request->getParsedBody();
    }
}
