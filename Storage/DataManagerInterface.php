<?php

namespace Craue\FormFlowBundle\Storage;

use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface DataManagerInterface {

	/**
	 * Key for storing data of all flows.
	 */
	const string STORAGE_ROOT = 'craue_form_flow';

	function getStorage(): StorageInterface;

	/**
	 * Saves data of the given flow.
	 * @param FormFlowInterface $flow
	 * @param array $data
	 */
	function save(FormFlowInterface $flow, array $data);

	/**
	 * Checks if data exists for a given flow.
	 */
	function exists(FormFlowInterface $flow): bool;

	/**
	 * Loads data of the given flow.
	 */
	function load(FormFlowInterface $flow): array;

	/**
	 * Drops data of the given flow.
	 */
	function drop(FormFlowInterface $flow);

}
