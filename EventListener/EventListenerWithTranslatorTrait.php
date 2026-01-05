<?php

namespace Craue\FormFlowBundle\EventListener;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
trait EventListenerWithTranslatorTrait {

	protected TranslatorInterface $translator;

	/**
	 * @param TranslatorInterface $translator
	 */
	public function setTranslator(TranslatorInterface $translator): void
    {
		$this->translator = $translator;
	}
}
