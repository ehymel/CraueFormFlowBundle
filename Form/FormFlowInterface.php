<?php

namespace Craue\FormFlowBundle\Form;

use Craue\FormFlowBundle\Exception\InvalidTypeException;
use Craue\FormFlowBundle\Storage\DataManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface FormFlowInterface {

	function getName(): string;

	function setFormFactory(FormFactoryInterface $formFactory);

	function setRequestStack(RequestStack $requestStack);

	function setDataManager(DataManagerInterface $dataManager);

	function getDataManager(): DataManagerInterface;

	function setEventDispatcher(EventDispatcherInterface $eventDispatcher);

	function isRevalidatePreviousSteps(): bool;

	function isAllowDynamicStepNavigation(): bool;

	/**
	 * If file uploads should be handled by serializing them into the storage.
	 */
	function isHandleFileUploads(): bool;

	/**
	 * Directory for storing temporary files while handling uploads. If <code>null</code>, the system's default will be used.
	 */
	function getHandleFileUploadsTempDir(): ?string;

	function isAllowRedirectAfterSubmit(): bool;

	function getId(): string;

	function getInstanceId(): string;

	/**
	 * Restores previously saved form data of all steps and determines the current step.
	 */
	function bind(mixed $formData);

	function getFormData(): mixed;

	/**
	 * Creates the form for the current step.
	 * @return FormInterface
	 */
	function createForm(): FormInterface;

	function isStepDone(int $stepNumber): bool;

	function isStepSkipped(int $stepNumber): bool;

	function isValid(FormInterface $form): bool;

	/**
	 * Saves the form data of the current step.
	 */
	function saveCurrentStepData(FormInterface $form): void;

	/**
	 * Proceeds to the next step.
	 * @return bool Whether the next step can be prepared. If not, the flow is finished.
	 */
	function nextStep(): bool;

	/**
	 * Resets the flow and clears its underlying storage.
	 */
	function reset(): void;

	/**
	 * First visible step, which may be greater than 1 if steps are skipped.
	 */
	function getFirstStepNumber(): int;

	/**
	 * Last visible step, which may be less than <code>getStepCount()</code> if steps are skipped.
	 */
	function getLastStepNumber(): int;

	/**
	 * @throws \RuntimeException If the current step is not yet known.
	 */
	function getCurrentStepNumber(): int;

	/**
	 * The label for the current step.
	 */
	function getCurrentStepLabel(): ?string;

	/**
	 * Get labels for all steps used to render the step list.
	 * @return string[]|null[] Value with index 0 is the label for step 1.
	 */
	function getStepLabels(): array;

	/**
	 * @throws InvalidTypeException If <code>$stepNumber</code> is not an integer.
	 * @throws \OutOfBoundsException If step <code>$stepNumber</code> doesn't exist.
	 */
	function getStep(int $stepNumber): StepInterface;

	/**
	 * @return StepInterface[] Value with index 0 is step 1.
	 */
	function getSteps(): array;

	function getStepCount(): int;

	/**
	 * @return StepInterface[] Steps done.
	 */
	function getStepsDone(): array;

	/**
	 * @return StepInterface[] Steps remaining.
	 */
	function getStepsRemaining(): array;

	/**
	 * Count of steps done.
	 */
	function getStepsDoneCount(): int;

	/**
	 * Count of steps remaining.
	 */
	function getStepsRemainingCount(): int;
}
