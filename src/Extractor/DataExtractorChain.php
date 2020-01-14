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
use Mezzio\ContentValidation\Exception\UnexpectedValueException;
use Laminas\Stdlib\ArrayUtils;

/**
 * Class DataExtractorChain
 *
 * @package Mezzio\ContentValidation\Extractor
 */
class DataExtractorChain
{
    /**
     * @var array<DataExtractorInterface>
     */
    protected $extractors = [];

    /**
     * DataExtractorChain constructor.
     *
     * @param array $extractors
     */
    public function __construct(array $extractors)
    {
        $this->extractors = $extractors;
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    public function getDataFromRequest(ServerRequestInterface $request): array
    {
        $result = [];

        $dataSets = array_map(
            function (DataExtractorInterface $extractor) use ($request) {
                $data = $extractor->extractData($request);

                if ($data instanceof \Traversable) {
                    $data = iterator_to_array($data);
                }

                if (! is_array($data)) {
                    throw new UnexpectedValueException(
                        sprintf(
                            'Data Extractor `%s` returned a `%s` instead of an `array`',
                            get_class($extractor),
                            is_object($data) ? get_class($data) : gettype($data)
                        )
                    );
                }

                return $data;
            },
            $this->extractors
        );

        foreach ($dataSets as $data) {
            $result = ArrayUtils::merge($result, $data);
        }

        return $result;
    }
}
