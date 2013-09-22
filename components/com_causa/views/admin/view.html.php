<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class CausaViewAdmin extends JView
{
        protected $buttons;

        /**
         * Display the view
         */
        public function display($tpl = null)
        {
                $calendario = new Calendario();
				
				$this->buttons		= & $this->get( 'Botones');
				$this->audiencias		= & $this->get( 'Audiencias');
				
				//$this->CalendarioAudiencias = $calendario->getCalendarioCausa($this->audiencias); 
                //$this->CalendarioAudiencias = $calendario->getCalendario($this->audiencias); 
                
				// Check for errors.
                if (count($errors = $this->get('Errors'))) {
                        JError::raiseError(500, implode("\n", $errors));
                        return false;
                }


		
				//$this->addDocument();
                parent::display($tpl);
        }
/*
        protected function addDocument()
        {
                $document       = & JFactory::getDocument();
              
                require_once JPATH_COMPONENT.DS.'helpers'.DS.'causa.php';
				require_once( 'components' . DS . 'com_causa' . DS . 'helpers' . DS . 'calendario.helper.php');
        }
	*/	

}
