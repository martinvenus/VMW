<?php

/**
 * This file is part of the Nette Framework.
 *
 * Copyright (c) 2004, 2010 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 * @package Nette\Reflection
 */



/**
 * Reports information about a function.
 *
 * @author     David Grudl
 */
class NFunctionReflection extends ReflectionFunction
{
	/** @var string|Closure */
	private $value;


	public function __construct($name)
	{
		parent::__construct($this->value = $name);
	}



	public function __toString()
	{
		return 'Function ' . $this->getName() . '()';
	}



	public function getClosure()
	{
		return $this->isClosure() ? $this->value : NULL;
	}



	/********************* Reflection layer ****************d*g**/



	/**
	 * @return NExtensionReflection
	 */
	public function getExtension()
	{
		return ($name = $this->getExtensionName()) ? new NExtensionReflection($name) : NULL;
	}



	public function getParameters()
	{
		foreach ($res = parent::getParameters() as $key => $val) {
			$res[$key] = new NParameterReflection($this->value, $val->getName());
		}
		return $res;
	}



	/********************* NObject behaviour ****************d*g**/



	/**
	 * @return NClassReflection
	 */
	public function getReflection()
	{
		return new NClassReflection($this);
	}



	public function __call($name, $args)
	{
		return NObjectMixin::call($this, $name, $args);
	}



	public function &__get($name)
	{
		return NObjectMixin::get($this, $name);
	}



	public function __set($name, $value)
	{
		return NObjectMixin::set($this, $name, $value);
	}



	public function __isset($name)
	{
		return NObjectMixin::has($this, $name);
	}



	public function __unset($name)
	{
		throw new MemberAccessException("Cannot unset the property {$this->reflection->name}::\$$name.");
	}

}
