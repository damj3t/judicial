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
class CausaViewArchivos extends JView
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

                $this->addDocument();
                parent::display($tpl);
        }

        protected function addDocument()
        {
                $document       = & JFactory::getDocument();
              
                require_once JPATH_COMPONENT.DS.'helpers'.DS.'causa.php';
                $state  = $this->get('State');
                $canDo  = CausaHelper::getActions();


        }
}
