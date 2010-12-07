<?php
/**
 * Flickr - feature-based reranking
 * MI-VMW at CZECH TECHNICAL UNIVERSITY IN PRAGUE
 *
 * @copyright  Copyright (c) 2010
 * @package    VMW
 * @author     Jaroslav Líbal, Martin Venuš
 */

/**
 *
 * ErrorPresenter
 *
 */
class ErrorPresenter extends BasePresenter
{

	/**
	 * @param  Exception
	 * @return void
	 */
	public function renderDefault($exception)
	{
		if ($this->isAjax()) { // AJAX request? Just note this error in payload.
			$this->payload->error = TRUE;
			$this->terminate();

		} elseif ($exception instanceof NBadRequestException) {
			$this->setView('404'); // load template 404.phtml

		} else {
			$this->setView('500'); // load template 500.phtml
			NDebug::processException($exception); // and handle error by NDebug
		}
	}

}
