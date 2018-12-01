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
use Zend\Expressive\ContentValidation\Exception\UnexpectedValueException;
use Zend\Stdlib\ArrayUtils;

/**
 * Class DataExtractorChain
 *
 * @package Zend\Expressive\ContentValidation\Extractor
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
