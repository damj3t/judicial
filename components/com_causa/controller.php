<?php
/**
 * @package Joomla
 * @subpackage Causa 
 * @copyright (C) 2013 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class CausaController extends JController{

	function display($cachable = false, $urlparams = false)
	{
		parent::display($cachable = false, $urlparams = false);
		return $this;
	}

}
