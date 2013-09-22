<?php
//----------------------------------------------------------------------
// Sophia
// Sophia by Alex Olave - http://www.alfazeta.cl
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Author: 	Alex Olave - http://www.alfazeta.cl
// Copyright: copyright (C) 2012 - Alex Olave.
// License: 	GNU/GPL, http://www.gnu.org/copyleft/gpl.html
// Pack: 	Sophia
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Sophia is free software. This version may have been modified pursuant
// to the GNU General Public License, and as distributed it includes or
// is derivative of works licensed under the GNU General Public License or
// other free or open source software licenses.
//----------------------------------------------------------------------

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class CausaViewAgenda extends JView
{

		protected $form;
        protected $item;
        protected $state;
		protected $config;

	function display($tpl = null)
	{
	
		// Initialise variables.
        $this->form     = $this->get('Form');
        $this->item     = $this->get('Item');
        $this->state    = $this->get('State');
		
		$this->config =& JComponentHelper::getParams( 'com_causa' );
        $this->imageconfig=& JComponentHelper::getParams('com_media');
        $this->session=& JFactory::getSession();
		
				// Check for errors.
		if (count($errors = $this->get('Errors'))) {
				JError::raiseError(500, implode("\n", $errors));
				return false;
		}		
	
		//Data from model
		//$model = $this->getModel();
		//$agenda		=& $this->get('Data');
		$document       = & JFactory::getDocument();
        $document->addStyleSheet('components/com_causa/assets/css/com_causa.css');
		
		$isNew		= ($this->item->id == 0);
		$text = $isNew ? JText::_( 'NUEVO' ) : JText::_( 'EDITAR' );

		JToolBarHelper::title(   '&nbsp;&nbsp;' .JText::_( 'COM_TECNOMED_AGENDA' ).': <small><small>[ ' . $text.' ]</small></small>', 'agenda');

		JToolBarHelper::apply('agenda.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('agenda.save', 'JTOOLBAR_SAVE');
                
		JToolBarHelper::cancel('agenda.cancel');

		parent::display($tpl);
	}
}
