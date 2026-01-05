<?php

namespace Craue\FormFlowBundle\Storage;

use Craue\FormFlowBundle\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Stores data in the session.
 *
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 * @copyright 2011-2025 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class SessionStorage implements StorageInterface {

	use SessionProviderTrait;

	/**
	 * @param RequestStack|SessionInterface $requestStackOrSession
	 * @throws InvalidTypeException
	 */
	public function __construct(RequestStack|SessionInterface $requestStackOrSession) {
		$this->setRequestStackOrSession($requestStackOrSession);
	}

	/**
	 * {@inheritDoc}
	 */
	public function set(string $key, mixed $value): void
    {
		$this->getSession()->set($key, $value);
	}

	/**
	 * {@inheritDoc}
	 */
	public function get($key, mixed $default = null): mixed
    {
		return $this->getSession()->get($key, $default);
	}

	/**
	 * {@inheritDoc}
	 */
	public function has($key): bool
    {
		return $this->getSession()->has($key);
	}

	/**
	 * {@inheritDoc}
	 */
	public function remove($key): void
    {
		$this->getSession()->remove($key);
	}

}
