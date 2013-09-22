<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
JHTML::_( 'behavior.modal' );
class CausaViewCausas extends JView
{
	protected $items;
        protected $pagination;
        protected $state;

        /**
         * Display the view
         */
        public function display($tpl = null)
        {
                $this->state            = $this->get('State');
                $this->items            = $this->get('Items');
                $this->pagination       = $this->get('Pagination');

                // Check for errors.
                if (count($errors = $this->get('Errors'))) {
                        JError::raiseError(500, implode("\n", $errors));
                        return false;
                }

                $this->addToolbar();
                parent::display($tpl);
        }

        protected function addToolbar()
        {
                $document       = & JFactory::getDocument();
                $document->addScript(DS.'includes'.DS.'js'.DS.'overlib_mini.js');

                require_once JPATH_COMPONENT.DS.'helpers'.DS.'causa.php';
                $state  = $this->get('State');
                $canDo  = CausaHelper::getActions();


        }
}
