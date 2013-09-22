<?php
//----------------------------------------------------------------------
// 
// Systemed by Alex Olave - http://www.alfazeta.cl
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Author: 	Alex Olave - http://www.alfazeta.cl
// Copyright: copyright (C) 2013 - Alex Olave
// License: 	GNU/GPL, http://www.gnu.org/copyleft/gpl.html
// Pack: 	
//----------------------------------------------------------------------
//----------------------------------------------------------------------


defined( '_JEXEC' ) or die( 'Restricted access' );

class CausaControllerPdf extends SophiaController
{
	function __construct()
	{
		parent::__construct();
		$this->cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
	}

}
