<?php

namespace Craue\FormFlowBundle\Event;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Is called once if revalidating previous steps failed.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class PreviousStepInvalidEvent extends FormFlowEvent {

	/**
	 * @param FormFlowInterface $flow
	 * @param FormInterface $currentStepForm
	 * @param int $invalidStepNumber
	 */
	public function __construct(FormFlowInterface $flow, protected FormInterface $currentStepForm, protected int $invalidStepNumber) {
		parent::__construct($flow);
		$this->currentStepForm = $currentStepForm;
		$this->invalidStepNumber = $invalidStepNumber;
	}

	public function getCurrentStepForm(): FormInterface
    {
		return $this->currentStepForm;
	}

	public function getInvalidStepNumber(): int
    {
		return $this->invalidStepNumber;
	}
}
