<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Validator;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\ContentValidation\Exception\NoValidationClassExists;
use Zend\Expressive\ContentValidation\Extractor\DataExtractorChain;
use Zend\Expressive\ContentValidation\Extractor\OptionsExtractor;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ValidatorHandler
 *
 * @package Zend\Expressive\ContentValidation\Validator
 */
final class ValidatorHandler implements ValidatorHandlerInterface
{
    /**
     * @var OptionsExtractor
     */
    private $optionsExtractor;

    /**
     * @var DataExtractorChain
     */
    private $dataExtractorChain;

    /**
     * @var ContainerInterface
     */
    private $inputFilterManager;

    /**
     * ValidatorHandler constructor.
     *
     * @param OptionsExtractor $optionsExtractor
     * @param DataExtractorChain $dataExtractorChain
     * @param ContainerInterface $inputFilterManager
     */
    public function __construct(
        OptionsExtractor $optionsExtractor,
        DataExtractorChain $dataExtractorChain,
        ContainerInterface $inputFilterManager
    ) {
        $this->optionsExtractor = $optionsExtractor;
        $this->dataExtractorChain = $dataExtractorChain;
        $this->inputFilterManager = $inputFilterManager;
    }

    /**
     * Validates the request
     *
     * @param ServerRequestInterface $request
     * @return bool|ValidationResult
     * @throws NoValidationClassExists
     */
    public function validate(ServerRequestInterface $request)
    {
        $validatorProvider = $this->getValidatorObject($request);

        if ($validatorProvider instanceof InputFilterInterface) {
            $data = $this->dataExtractorChain->getDataFromRequest($request);
            $validatorProvider->setData($data);

            return ValidationResult::buildFromInputFilter($validatorProvider, $request->getMethod());
        }

        return true;
    }

    /**
     * Checks an returns the validation object
     * or null otherwise
     *
     * @param ServerRequestInterface $request
     * @return null|InputFilterInterface
     * @throws NoValidationClassExists
     */
    private function getValidatorObject(ServerRequestInterface $request): ?InputFilterInterface
    {
        $routeValidationConfig = $this->optionsExtractor->getOptionsForRequest($request);

        if (isset($routeValidationConfig)) {
            $method = strtolower($request->getMethod());
            $validation = array_change_key_case($routeValidationConfig, CASE_LOWER);

            if (array_key_exists($method, $validation)) {
                return $this->getInputFilter($validation[$method]);
            } elseif (array_key_exists('*', $validation)) {
                return $this->getInputFilter($validation['*']);
            }
        }

        return null;
    }

    /**
     * @param $inputFilterService
     * @return InputFilterInterface
     * @throws NoValidationClassExists
     */
    private function getInputFilter($inputFilterService): InputFilterInterface
    {
        $inputFilter = $this->inputFilterManager->get($inputFilterService);

        if (! $inputFilter instanceof InputFilterInterface) {
            throw new NoValidationClassExists(
                sprintf(
                    'Listed input filter "%s" does not exist; cannot validate request',
                    $inputFilterService
                )
            );
        }

        return $this->inputFilterManager->get($inputFilterService);
    }
}
