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
 * BasePresenter
 *
 */
abstract class BasePresenter extends NPresenter
{
	public $oldLayoutMode = FALSE;

        public function startup(){
            parent::startup();

            NDebug::timer();
        }

}
