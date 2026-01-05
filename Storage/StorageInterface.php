<?php

namespace Craue\FormFlowBundle\Storage;

/**
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface StorageInterface {

	/**
	 * Store the given value under the given key.
	 * @param string $key
	 * @param mixed $value
	 */
	function set(string $key, mixed $value);

	/**
	 * Retrieve the data stored under the given key.
	 */
	function get(string $key, mixed $default = null): mixed;

	/**
	 * Checks if data is stored for the given key.
	 * @param string $key
	 * @return bool
	 */
	function has(string $key): bool;

	/**
	 * Delete the stored data of the given key.
	 * @param string $key
	 */
	function remove(string $key);

}
