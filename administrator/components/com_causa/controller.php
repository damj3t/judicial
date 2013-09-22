<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class CausaController extends JController
{
	protected $default_view = 'cpanel';

	public function display($cachable = false, $urlparams = false)
        {
                require_once JPATH_COMPONENT.'/helpers/causa.php';

                parent::display();

                // Load the submenu.
                CausaHelper::addSubmenu(JRequest::getWord('view', 'cpanel'));

                return $this;
        }
}
