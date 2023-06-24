<?php

namespace Itsmattch\Nexus\Address\Parameter;

use Itsmattch\Nexus\Address\Contract\Parameter as ParameterContract;

/**
 * ParameterProxy is responsible for wrapping Parameters
 * and altering their values with capture and release
 * callbacks.
 */
class ParameterProxy implements ParameterContract
{
    /** The original parameter. */
    protected ParameterContract $parameter;

    /** The callback called upon setting value. */
    protected array $captureCallback;

    /** The callback called upon getting value. */
    protected array $releaseCallback;

    /**
     * ParameterProxy constructor.
     *
     * @param ParameterContract $parameter The original
     * parameter.
     * @param array $captureCallback The callback called
     * upon setting value.
     * @param array $releaseCallback The callback called
     * upon getting value.
     */
    public function __construct(ParameterContract $parameter, array $captureCallback, array $releaseCallback)
    {
        $this->parameter = $parameter;

        if (is_callable($captureCallback) && method_exists($captureCallback[0], $captureCallback[1])) {
            $this->captureCallback = $captureCallback;
        }

        if (is_callable($releaseCallback) && method_exists($releaseCallback[0], $releaseCallback[1])) {
            $this->releaseCallback = $releaseCallback;
        }
    }

    /**
     * Returns the value of the parameter, applying
     * the release callback if available.
     *
     * @return string The parameter value.
     */
    public function getValue(): string
    {
        if (isset($this->releaseCallback)) {
            return call_user_func($this->releaseCallback, $this->parameter->getValue());
        }
        return $this->parameter->getValue();
    }

    /**
     * Sets the value of the parameter, applying
     * the capture callback if available.
     *
     * @param mixed $value
     */
    public function setValue(mixed $value): void
    {
        if (isset($this->captureCallback)) {
            $value = call_user_func($this->captureCallback, $this->parameter->getValue());
        }
        $this->parameter->setValue($value);
    }

    public function getLiteral(): string
    {
        return $this->parameter->getLiteral();
    }

    public function getName(): string
    {
        return $this->parameter->getName();
    }

    public function isValid(): bool
    {
        return $this->parameter->isValid();
    }

}