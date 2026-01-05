<?php

namespace Craue\FormFlowBundle\Form;

use Craue\FormFlowBundle\Exception\InvalidTypeException;
use Craue\FormFlowBundle\Exception\StepLabelCallableInvalidReturnValueException;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class StepLabel {

	/**
	 * If <code>$value</code> is callable.
	 */
	private bool $callable;

	/**
	 * @var string|callable|null
	 */
	private $value = null;

	public static function createStringLabel(?string $value): static
    {
		return new static($value);
	}

	public static function createCallableLabel(callable $value): static
    {
		return new static($value, true);
	}

	public function getText(): callable|string|null
    {
		if ($this->callable) {
			$returnValue = call_user_func($this->value);

			if ($returnValue === null || is_string($returnValue)) {
				return $returnValue;
			}

			throw new StepLabelCallableInvalidReturnValueException();
		}

		return $this->value;
	}

	private final function __construct(callable|string|null $value, bool $callable = false) {
		$this->setValue($value, $callable);
	}

	private function setValue(callable|string|null $value, bool $callable = false): void
    {
		if ($callable) {
			if (!is_callable($value)) {
				throw new InvalidTypeException($value, ['callable']);
			}
		} else {
			if ($value !== null && !is_string($value)) {
				throw new InvalidTypeException($value, ['null', 'string']);
			}
		}

		$this->callable = $callable;
		$this->value = $value;
	}

}
