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
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class FileExtractor
 *
 * @package Zend\Expressive\ContentValidation\Extractor
 */
class FileExtractor implements DataExtractorInterface
{
    /**
     * @inheritDoc
     */
    public function extractData(ServerRequestInterface $request)
    {
        $files = [];
        $uploadedFiles = $request->getUploadedFiles();

        if (! empty($uploadedFiles)) {
            foreach ($uploadedFiles as $key => $uploadedFile) {
                $files[$key] = $this->uploadedFileToArray($uploadedFile);
            }
        }

        return $files;
    }

    /**
     * @param UploadedFileInterface $uploadedFile
     * @return array
     */
    private function uploadedFileToArray(UploadedFileInterface $uploadedFile)
    {
        if (! $uploadedFile->getError()) {
            $stream = $uploadedFile->getStream();

            return [
                'tmp_name' => ($stream) ? $stream->getMetadata('uri') : '',
                'name' => $uploadedFile->getClientFilename(),
                'type' => $uploadedFile->getClientMediaType(),
                'size' => $uploadedFile->getSize(),
                'error' => $uploadedFile->getError()
            ];
        }

        return [];
    }
}
