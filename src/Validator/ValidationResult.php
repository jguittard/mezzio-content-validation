<?php
/**
 * @see       https://github.com/jguittard/zend-expressive-content-validation for the canonical source repository
 * @copyright Copyright (c) 2018 Julien Guittard. (https://julien.guittard.io)
 * @license   https://github.com/jguittard/zend-expressive-content-validation/blob/master/LICENSE.md
 *     MIT License
 */
declare(strict_types=1);

namespace Zend\Expressive\ContentValidation\Validator;

use Zend\InputFilter\InputFilterInterface;

/**
 * Class ValidationResult
 *
 * @package Zend\Expressive\ContentValidation\Validator
 */
final class ValidationResult implements ValidationResultInterface
{
    /**
     * @var array
     */
    private $rawValues;

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $messages;

    /**
     * @var null|string
     */
    private $method;

    /**
     * ValidationResult constructor.
     *
     * @param array $rawValues
     * @param array $values
     * @param array $messages
     * @param null|string $method
     */
    public function __construct(array $rawValues, array $values, array $messages, ?string $method = null)
    {
        $this->rawValues = $rawValues;
        $this->values = $values;
        $this->messages = $messages;
        $this->method = $method;
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @param $method
     * @return ValidationResult
     */
    public static function buildFromInputFilter(InputFilterInterface $inputFilter, $method): self
    {
        $messages = [];

        if (! $inputFilter->isValid()) {
            foreach ($inputFilter->getInvalidInput() as $message) {
                $messages[$message->getName()] = $message->getMessages();
            }
        }

        return new self(
            $inputFilter->getRawValues(),
            $inputFilter->getValues(),
            $messages,
            $method
        );
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        return count($this->messages) === 0;
    }

    /**
     * @inheritdoc
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @inheritdoc
     */
    public function getRawValues(): array
    {
        return $this->rawValues;
    }

    /**
     * @inheritdoc
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
