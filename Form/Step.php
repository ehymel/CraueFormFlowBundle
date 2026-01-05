<?php

namespace Craue\FormFlowBundle\Form;

use Craue\FormFlowBundle\Exception\InvalidTypeException;
use Craue\FormFlowBundle\Exception\StepLabelCallableInvalidReturnValueException;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Step implements StepInterface {

	protected int $number;

	protected string|null|StepLabel $label = null;

	protected string|FormTypeInterface|null $formType = null;

	protected array $formOptions = [];

	/**
	 * @var callable|null
	 */
	private $skipFunction = null;

	/**
	 * Is only null if not yet evaluated.
	 */
	private ?bool $skipped = false;

	public static function createFromConfig($number, array $config): static
    {
		$step = new static();

		$step->setNumber($number);

		foreach ($config as $key => $value) {
			switch ($key) {
				case 'label':
					$step->setLabel($value);
					break;
				case 'type':
					@trigger_error('Step config option "type" is deprecated since CraueFormFlowBundle 3.0. Use "form_type" instead.', E_USER_DEPRECATED);
				case 'form_type':
					$step->setFormType($value);
					break;
				case 'form_options':
					$step->setFormOptions($value);
					break;
				case 'skip':
					$step->setSkip($value);
					break;
				default:
					throw new \InvalidArgumentException(sprintf('Invalid step config option "%s" given.', $key));
			}
		}

		return $step;
	}

	public function setNumber(int $number): void
    {
		if (is_int($number)) {
			$this->number = $number;

			return;
		}

		throw new InvalidTypeException($number, 'int');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getNumber(): int
    {
		return $this->number;
	}

	public function setLabel(StepLabel|string|null $label): void
    {
		if (is_string($label)) {
			$this->label = StepLabel::createStringLabel($label);

			return;
		}

		if ($label === null || $label instanceof StepLabel) {
			$this->label = $label;

			return;
		}

		throw new InvalidTypeException($label, ['null', 'string', StepLabel::class]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLabel(): ?string
    {
		try {
			return $this->label !== null ? $this->label->getText() : null;
		} catch (StepLabelCallableInvalidReturnValueException $e) {
			throw new \RuntimeException(sprintf('The label callable for step %d did not return a string or null value.',
					$this->number));
		}
	}

	/**
	 * @throws InvalidTypeException
	 */
	public function setFormType(FormTypeInterface|string|null $formType): void
    {
		if ($formType === null || is_string($formType) || $formType instanceof FormTypeInterface) {
			$this->formType = $formType;

			return;
		}

		throw new InvalidTypeException($formType, ['null', 'string', FormTypeInterface::class]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType(): FormTypeInterface|string|null
    {
		return $this->formType;
	}

	public function setFormOptions(array $formOptions): void
    {
		if (is_array($formOptions)) {
			$this->formOptions = $formOptions;

			return;
		}

		throw new InvalidTypeException($formOptions, 'array');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormOptions(): array
    {
		return $this->formOptions;
	}

	/**
	 * @param callable|bool $skip
	 * @throws InvalidTypeException
	 */
	public function setSkip(callable|bool $skip): void
    {
		if (is_bool($skip)) {
			$this->skipFunction = null;
			$this->skipped = $skip;

			return;
		}

		if (is_callable($skip)) {
			$this->skipFunction = $skip;
			$this->skipped = null;

			return;
		}

		throw new InvalidTypeException($skip, ['bool', 'callable']);
	}

	/**
	 * {@inheritDoc}
	 */
	public function evaluateSkipping(int $estimatedCurrentStepNumber, FormFlowInterface $flow): void
    {
		if ($this->skipFunction !== null) {
			$returnValue = ($this->skipFunction)(...[$estimatedCurrentStepNumber, $flow]);

			if (!is_bool($returnValue)) {
				throw new \RuntimeException(sprintf('The skip callable for step %d did not return a boolean value.',
						$this->number));
			}

			$this->skipped = $returnValue;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSkipped(): bool
    {
		return $this->skipped === true;
	}

}
