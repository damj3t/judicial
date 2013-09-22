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

jimport('joomla.application.component.modeladmin');

class CausaModelAuthor extends JModelAdmin
{
	protected $text_prefix = 'COM_TECNOMED';


	protected function canDelete($record)
        {
                $user = JFactory::getUser();

		if ($record->catid) {
			return $user->authorise('core.delete', 'com_causa.category.'.(int) $record->id);
		} else {
                        return parent::canDelete($record);
                }
        }



	protected function canEditState($record)
        {
                $user = JFactory::getUser();

		return $user->authorise('core.edit.state', 'com_causa.category.'.(int) $record->id);
        }



	public function getTable($type = 'Author', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }



	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.author', 'author', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.author.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }


	protected function prepareTable(&$table)
        {
                $table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
		$table->alias           = JApplication::stringURLSafe($table->name);
		
        }
	
	

}
