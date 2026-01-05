<?php

namespace Craue\FormFlowBundle\Event;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Is called once if an expired flow is detected.
 *
 * @author Tim Behrendsen <tim@siliconengine.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FlowExpiredEvent extends FormFlowEvent {

	public function __construct(FormFlowInterface $flow, protected FormInterface $currentStepForm) {
		parent::__construct($flow);
	}

	public function getCurrentStepForm(): FormInterface
    {
		return $this->currentStepForm;
	}
}
