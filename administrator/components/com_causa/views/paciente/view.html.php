<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 * @license GNU/GPL, see LICENSE.php
 * Causa is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Causa is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Causa; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class CausaViewPaciente extends JView
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
                parent::display($tpl);
                // Set the document
				$this->setDocument();
        }

	protected function addToolbar()
        {
                JRequest::setVar('hidemainmenu', true);

                $user           = JFactory::getUser();
                $isNew          = ($this->item->id == 0);
                $canDo          = CausaHelper::getActions();

		$document       = & JFactory::getDocument();
        $document->addStyleSheet('components/com_causa/assets/css/com_causa.css');
		$icon = $isNew ? 'pacientesadd' : 'pacientes';
		JToolBarHelper::title(JText::_(($isNew ? 'COM_TECNOMED_PAGE_ADD_PACIENTE' : 'COM_TECNOMED_PAGE_VIEW_PACIENTE')), $icon);

                // If not checked out, can save the item.
                if (!$checkedOut && $canDo->get('core.edit')) {
                        JToolBarHelper::apply('paciente.apply', 'JTOOLBAR_APPLY');
                        JToolBarHelper::save('paciente.save', 'JTOOLBAR_SAVE');
                }

                if (empty($this->item->id))  {
                        JToolBarHelper::cancel('paciente.cancel');
                } else {
                        JToolBarHelper::cancel('paciente.cancel', 'JTOOLBAR_CLOSE');
                }
        }
		protected function setDocument() 
			{
				$isNew = $this->item->id == 0;
				$document = JFactory::getDocument();
				$document->setTitle($isNew ? JText::_('COM_TECNOMED_PACIENTE_NUEVO') : JText::_('COM_TECNOMED_PACIENTE_EDITAR'));
				$document->addScript(JURI::root() . $this->script);
				$document->addScript(JURI::root() . "/administrator/components/com_causa/views/paciente/submitbutton.js");
				JText::script('COM_TECNOMED_PACIENTE_ERROR_INACEPTABLE');
			}    
}
