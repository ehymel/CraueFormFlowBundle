<?php

namespace Craue\FormFlowBundle\Form;

use Symfony\Component\Form\FormTypeInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface StepInterface {

	function getNumber(): int;

	function getLabel(): ?string;

	function getFormType(): FormTypeInterface|string|null;

	function getFormOptions(): array;

	function isSkipped(): bool;

	function evaluateSkipping(int $estimatedCurrentStepNumber, FormFlowInterface $flow);

}
