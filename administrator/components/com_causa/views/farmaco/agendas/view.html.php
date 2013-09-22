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
class CausaViewAgendas extends JView
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
                $document->addStyleSheet('components/com_causa/assets/css/com_causa.css');
                $document->addScript(DS.'includes'.DS.'js'.DS.'overlib_mini.js');

                require_once JPATH_COMPONENT.DS.'helpers'.DS.'tecnomed.php';
                $state  = $this->get('State');
                $canDo  = CausaHelper::getActions();

                JToolBarHelper::title(JText::_( 'COM_TECNOMED_AGENDA_MANAGER' ), 'agenda' );
              //  if ($canDo->get('core.create')) {
                        JToolBarHelper::addNew('agenda.add','JTOOLBAR_NEW');
             //   }
             //   if ($canDo->get('core.edit')) {
                        JToolBarHelper::editList('agenda.edit','JTOOLBAR_EDIT');
            //    }

		//if ($canDo->get('core.delete')) {
                        JToolBarHelper::deleteList('', 'agendas.delete','JTOOLBAR_DELETE');
		//}

		//if ($canDo->get('core.admin')) {
                        JToolBarHelper::divider();
                        JToolBarHelper::preferences('com_causa');
       //         }
        }
}
