<?php

namespace Craue\FormFlowBundle\Event;

use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 * Is called once for the current step after binding the request.
 *
 * @author Marcus Stöhr <dafish@soundtrack-board.de>
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class PostBindRequestEvent extends FormFlowEvent {

	/**
	 * @param FormFlowInterface $flow
	 * @param mixed $formData
	 * @param int $stepNumber
	 */
	public function __construct(FormFlowInterface $flow, protected mixed $formData, protected int $stepNumber) {
		parent::__construct($flow);
	}

	public function getFormData(): mixed
    {
		return $this->formData;
	}

	public function getStepNumber(): int
    {
		return $this->stepNumber;
	}
}
