<?php

/**
 * This file is part of the Nette Framework.
 *
 * Copyright (c) 2004, 2010 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 * @package Nette\Application
 */



/**
 * NPresenterComponent is the base class for all presenters components.
 *
 * Components are persistent objects located on a presenter. They have ability to own
 * other child components, and interact with user. Components have properties
 * for storing their status, and responds to user command.
 *
 * @author     David Grudl
 *
 * @property-read NPresenter $presenter
 */
abstract class NPresenterComponent extends NComponentContainer implements ISignalReceiver, IStatePersistent, ArrayAccess
{
	/** @var array */
	protected $params = array();



	/**
	 */
	public function __construct(IComponentContainer $parent = NULL, $name = NULL)
	{
		$this->monitor('NPresenter');
		parent::__construct($parent, $name);
	}



	/**
	 * Returns the presenter where this component belongs to.
	 * @param  bool   throw exception if presenter doesn't exist?
	 * @return NPresenter|NULL
	 */
	public function getPresenter($need = TRUE)
	{
		return $this->lookup('NPresenter', $need);
	}



	/**
	 * Returns a fully-qualified name that uniquely identifies the component
	 * within the presenter hierarchy.
	 * @return string
	 */
	public function getUniqueId()
	{
		return $this->lookupPath('NPresenter', TRUE);
	}



	/**
	 * This method will be called when the component (or component's parent)
	 * becomes attached to a monitored object. Do not call this method yourself.
	 * @param  IComponent
	 * @return void
	 */
	protected function attached($presenter)
	{
		if ($presenter instanceof NPresenter) {
			$this->loadState($presenter->popGlobalParams($this->getUniqueId()));
		}
	}



	/**
	 * Calls public method if exists.
	 * @param  string
	 * @param  array
	 * @return bool  does method exist?
	 */
	protected function tryCall($method, array $params)
	{
		$rc = $this->getReflection();
		if ($rc->hasMethod($method)) {
			$rm = $rc->getMethod($method);
			if ($rm->isPublic() && !$rm->isAbstract() && !$rm->isStatic()) {
				$rm->invokeNamedArgs($this, $params);
				return TRUE;
			}
		}
		return FALSE;
	}



	/**
	 * Access to reflection.
	 * @return NPresenterComponentReflection
	 */
	public function getReflection()
	{
		return new NPresenterComponentReflection($this);
	}



	/********************* interface IStatePersistent ****************d*g**/



	/**
	 * Loads state informations.
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		foreach ($this->getReflection()->getPersistentParams() as $nm => $meta)
		{
			if (isset($params[$nm])) { // ignore NULL values
				if (isset($meta['def'])) {
					if (is_array($params[$nm]) && !is_array($meta['def'])) {
						$params[$nm] = $meta['def']; // prevents array to scalar conversion
					} else {
						settype($params[$nm], gettype($meta['def']));
					}
				}
				$this->$nm = & $params[$nm];
			}
		}
		$this->params = $params;
	}



	/**
	 * Saves state informations for next request.
	 * @param  array
	 * @param  NPresenterComponentReflection (internal, used by NPresenter)
	 * @return void
	 */
	public function saveState(array & $params, $reflection = NULL)
	{
		$reflection = $reflection === NULL ? $this->getReflection() : $reflection;
		foreach ($reflection->getPersistentParams() as $nm => $meta)
		{
			if (isset($params[$nm])) {
				$val = $params[$nm]; // injected value

			} elseif (array_key_exists($nm, $params)) { // $params[$nm] === NULL
				continue; // means skip

			} elseif (!isset($meta['since']) || $this instanceof $meta['since']) {
				$val = $this->$nm; // object property value

			} else {
				continue; // ignored parameter
			}

			if (is_object($val)) {
				throw new InvalidStateException("Persistent parameter must be scalar or array, {$this->reflection->name}::\$$nm is " . gettype($val));

			} else {
				if (isset($meta['def'])) {
					settype($val, gettype($meta['def']));
					if ($val === $meta['def']) $val = NULL;
				} else {
					if ((string) $val === '') $val = NULL;
				}
				$params[$nm] = $val;
			}
		}
	}



	/**
	 * Returns component param.
	 * If no key is passed, returns the entire array.
	 * @param  string key
	 * @param  mixed  default value
	 * @return mixed
	 */
	final public function getParam($name = NULL, $default = NULL)
	{
		if (func_num_args() === 0) {
			return $this->params;

		} elseif (isset($this->params[$name])) {
			return $this->params[$name];

		} else {
			return $default;
		}
	}



	/**
	 * Returns a fully-qualified name that uniquely identifies the parameter.
	 * @return string
	 */
	final public function getParamId($name)
	{
		$uid = $this->getUniqueId();
		return $uid === '' ? $name : $uid . self::NAME_SEPARATOR . $name;
	}



	/**
	 * Returns array of classes persistent parameters. They have public visibility and are non-static.
	 * This default implementation detects persistent parameters by annotation @persistent.
	 * @return array
	 */
	public static function getPersistentParams()
	{
		$rc = new NClassReflection(func_get_arg(0));
		$params = array();
		foreach ($rc->getProperties(ReflectionProperty::IS_PUBLIC) as $rp) {
			if (!$rp->isStatic() && $rp->hasAnnotation('persistent')) {
				$params[] = $rp->getName();
			}
		}
		return $params;
	}



	/********************* interface ISignalReceiver ****************d*g**/



	/**
	 * Calls signal handler method.
	 * @param  string
	 * @return void
	 * @throws NBadSignalException if there is not handler method
	 */
	public function signalReceived($signal)
	{
		if (!$this->tryCall($this->formatSignalMethod($signal), $this->params)) {
			throw new NBadSignalException("There is no handler for signal '$signal' in {$this->reflection->name} class.");
		}
	}



	/**
	 * Formats signal handler method name -> case sensitivity doesn't matter.
	 * @param  string
	 * @return string
	 */
	public function formatSignalMethod($signal)
	{
		return $signal == NULL ? NULL : 'handle' . $signal; // intentionally ==
	}



	/********************* navigation ****************d*g**/



	/**
	 * Generates URL to presenter, action or signal.
	 * @param  string   destination in format "[[module:]presenter:]action" or "signal!" or "this"
	 * @param  array|mixed
	 * @return string
	 * @throws NInvalidLinkException
	 */
	public function link($destination, $args = array())
	{
		if (!is_array($args)) {
			$args = func_get_args();
			array_shift($args);
		}

		try {
			return $this->getPresenter()->createRequest($this, $destination, $args, 'link');

		} catch (NInvalidLinkException $e) {
			return $this->getPresenter()->handleInvalidLink($e);
		}
	}



	/**
	 * Returns destination as NLink object.
	 * @param  string   destination in format "[[module:]presenter:]view" or "signal!"
	 * @param  array|mixed
	 * @return NLink
	 */
	public function lazyLink($destination, $args = array())
	{
		if (!is_array($args)) {
			$args = func_get_args();
			array_shift($args);
		}

		return new NLink($this, $destination, $args);
	}



	/**
	 * @deprecated
	 */
	public function ajaxLink($destination, $args = array())
	{
		throw new DeprecatedException(__METHOD__ . '() is deprecated.');
	}



	/**
	 * Redirect to another presenter, action or signal.
	 * @param  int      [optional] HTTP error code
	 * @param  string   destination in format "[[module:]presenter:]view" or "signal!"
	 * @param  array|mixed
	 * @return void
	 * @throws NAbortException
	 */
	public function redirect($code, $destination = NULL, $args = array())
	{
		if (!is_numeric($code)) { // first parameter is optional
			$args = $destination;
			$destination = $code;
			$code = NULL;
		}

		if (!is_array($args)) {
			$args = func_get_args();
			if (is_numeric(array_shift($args))) array_shift($args);
		}

		$presenter = $this->getPresenter();
		$presenter->redirectUri($presenter->createRequest($this, $destination, $args, 'redirect'), $code);
	}



	/********************* interface ArrayAccess ****************d*g**/



	/**
	 * Adds the component to the container.
	 * @param  string  component name
	 * @param  IComponent
	 * @return void
	 */
	final public function offsetSet($name, $component)
	{
		$this->addComponent($component, $name);
	}



	/**
	 * Returns component specified by name. Throws exception if component doesn't exist.
	 * @param  string  component name
	 * @return IComponent
	 * @throws InvalidArgumentException
	 */
	final public function offsetGet($name)
	{
		return $this->getComponent($name, TRUE);
	}



	/**
	 * Does component specified by name exists?
	 * @param  string  component name
	 * @return bool
	 */
	final public function offsetExists($name)
	{
		return $this->getComponent($name, FALSE) !== NULL;
	}



	/**
	 * Removes component from the container.
	 * @param  string  component name
	 * @return void
	 */
	final public function offsetUnset($name)
	{
		$component = $this->getComponent($name, FALSE);
		if ($component !== NULL) {
			$this->removeComponent($component);
		}
	}

}
