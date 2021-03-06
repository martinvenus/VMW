<?php

/**
 * This file is part of the Nette Framework.
 *
 * Copyright (c) 2004, 2010 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 * @package Nette\Forms
 */



/**
 * Defines method that must implement form rendered.
 *
 * @author     David Grudl
 */
interface IFormRenderer
{

	/**
	 * Provides complete form rendering.
	 * @param  NForm
	 * @return string
	 */
	function render(NForm $form);

}
