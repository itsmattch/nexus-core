<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

use Itsmattch\Nexus\Stream\Component\Address\Contract\ParameterInterface;

/**
 * ParameterProxy is responsible for wrapping Parameters
 * and altering their values with capture and release
 * callbacks.
 */
class ParameterProxy implements ParameterInterface
{
    /** The original parameter. */
    protected Parameter $parameter;

    /** The callback called upon setting value. */
    protected array $captureCallback;

    /** The callback called upon getting value. */
    protected array $releaseCallback;

    public function __construct(Parameter $parameter, array $captureCallback, array $releaseCallback)
    {
        $this->parameter = $parameter;
        $this->captureCallback = $captureCallback;
        $this->releaseCallback = $releaseCallback;
    }

    public function getValue(): string
    {
        if (is_callable($this->releaseCallback) && method_exists($this->releaseCallback[0], $this->releaseCallback[1])) {
            return call_user_func($this->releaseCallback, $this->parameter->getValue());
        }
        return $this->parameter->getValue();
    }

    public function setValue($value): void
    {
        if (is_callable($this->captureCallback) && method_exists($this->captureCallback[0], $this->captureCallback[1])) {
            $value = call_user_func($this->captureCallback, $value);
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