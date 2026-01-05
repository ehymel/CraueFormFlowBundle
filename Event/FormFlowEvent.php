<?php

namespace Craue\FormFlowBundle\Event;

use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class FormFlowEvent extends Event {

	/**
	 * @param FormFlowInterface $flow
	 */
	public function __construct(protected FormFlowInterface $flow)
    {}

	public function getFlow(): FormFlowInterface
    {
		return $this->flow;
	}
}
