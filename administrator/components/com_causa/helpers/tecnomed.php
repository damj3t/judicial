<?php
/**
 * @package Joomla
 * @subpackage Tecnomed
 * @copyright (C) 2012 Alex Olave 
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Tecnomed is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Tecnomed; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class TecnomedHelper
{
        public static function addSubmenu($vName)
        {
		JSubMenuHelper::addEntry(
                        JText::_('COM_TECNOMED_SUBMENU_CPANEL'),
                        'index.php?option=com_tecnomed&view=cpanel',
                        $vName == 'cpanel'
                );

        }

	public static function getActions($categoryId = 0, $bookId = 0)
        {
                $user   = JFactory::getUser();
                $result = new JObject;

                if (empty($bookId) && empty($categoryId)) {
                        $assetName = 'com_tecnomed';
                }
                else if (empty($bookId)) {
                        $assetName = 'com_tecnomed.category.'.(int) $categoryId;
                }
                else {
                        $assetName = 'com_tecnomed.book.'.(int) $bookId;
                }

                $actions = array(
                        'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
                );

                foreach ($actions as $action) {
                        $result->set($action,   $user->authorise($action, $assetName));
                }

                return $result;
        }

	public static function getCategoryActions($extension, $categoryId = 0)
        {
                $user           = JFactory::getUser();
                $result         = new JObject;
                $parts          = explode('.',$extension);
                $component      = $parts[0];

                if (empty($categoryId)) {
                        $assetName = $component;
                }
                else {
                        $assetName = $component.'.category.'.(int) $categoryId;
                }

                $actions = array(
                        'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
                );

                foreach ($actions as $action) {
                        $result->set($action, $user->authorise($action, $assetName));
                }

                return $result;
        }
}
