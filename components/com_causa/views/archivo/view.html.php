<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class CausaViewArchivo extends JView
{

		protected $form;
        protected $item;
        protected $state;
		protected $config;

        /**
         * Display the view
         */
        public function display($tpl = null)
        {
                // Initialise variables.
                $this->form     = $this->get('Form');
                $this->item     = $this->get('Item');
                $this->state    = $this->get('State');
                $this->script 	= $this->get('Script');
		
		$this->config =& JComponentHelper::getParams( 'com_causa' );
                $this->imageconfig=& JComponentHelper::getParams('com_media');
                $this->session=& JFactory::getSession();

                // Check for errors.
                if (count($errors = $this->get('Errors'))) {
                        JError::raiseError(500, implode("\n", $errors));
                        return false;
                }

                $this->addToolbar();
				// Set the document
				$this->setDocument();
				
                parent::display($tpl);
                
        }

	protected function addToolbar()
        {
                $user           = JFactory::getUser();
                $isNew          = ($this->item->id == 0);

		$document       = & JFactory::getDocument();
        $document->addStyleSheet('components/com_causa/assets/css/com_causa.css');
		$icon = $isNew ? 'clienteadd' : 'clientes';


        }
		protected function setDocument() 
			{
				$isNew = $this->item->id == 0;
				$document = JFactory::getDocument();
				$document->setTitle($isNew ? JText::_('COM_CAUSA_ARCHIVO_NUEVO') : JText::_('COM_CAUSA_ARCHIVO_EDITAR'));
				$document->addScript(JURI::root() . $this->script);
				$document->addScript(JURI::root() . "/administrator/components/com_causa/views/cliente/submitbutton.js");
				JText::script('COM_CAUSA_CLIENTE_ERROR_INACEPTABLE');
			}    
}
