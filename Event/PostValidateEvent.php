<?php

namespace Craue\FormFlowBundle\Event;

use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 * Is called once for the current step after validating the form data.
 *
 * @author Marcus Stöhr <dafish@soundtrack-board.de>
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class PostValidateEvent extends FormFlowEvent {

	/**
	 * @param FormFlowInterface $flow
	 * @param mixed $formData
	 */
	public function __construct(FormFlowInterface $flow, protected mixed $formData) {
		parent::__construct($flow);
	}

	public function getFormData(): mixed {
		return $this->formData;
	}
}
