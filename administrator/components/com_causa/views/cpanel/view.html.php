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
class CausaViewCpanel extends JView
{
        protected $buttons;

        /**
         * Display the view
         */
        public function display($tpl = null)
        {
                $this->buttons       = $this->get('Buttons');

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

		JToolBarHelper::title(JText::_( 'COM_TECNOMED' ), 'tecnomed-main' );
                require_once JPATH_COMPONENT.DS.'helpers'.DS.'causa.php';
                $state  = $this->get('State');
                $canDo  = CausaHelper::getActions($state->get('filter.category_id'));

		if ($canDo->get('core.admin')) {
                        JToolBarHelper::preferences('com_causa');
                }
        }
}
