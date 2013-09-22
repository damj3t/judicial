<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class CausaViewImportar extends JView
{
	protected $items;
        protected $pagination;
        protected $state;

        /**
         * Display the view
         */
        public function display($tpl = null)
        {
				
                // Check for errors.
                if (count($errors = $this->get('Errors'))) {
                        JError::raiseError(500, implode("\n", $errors));
                        return false;
                }

				//$this->setDocument();

                //$upload_handler = new UploadHandler();
		}
		
	protected function setDocument() 
	{
			//$document = JFactory::getDocument();
			$document       = & JFactory::getDocument();
			require_once JPATH_COMPONENT.DS.'helpers'.DS.'causa.php';
            //require_once JPATH_COMPONENT.DS.'helpers'.DS.'UploadHandler.php';
		$document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION'));
	}

}
