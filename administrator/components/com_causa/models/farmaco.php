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

class CausaModelFarmaco extends JModelAdmin
{
	protected $text_prefix = 'COM_TECNOMED';



	public function getTable($type = 'Farmaco', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }

    public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.farmaco', 'farmaco', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.farmaco.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }
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

class CausaModelPaciente extends JModelAdmin
{
	protected $text_prefix = 'COM_TECNOMED';



	public function getTable($type = 'Paciente', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }


	public function getScript() 
	{
		return 'administrator/components/com_causa/models/forms/paciente.js';
	}
	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.paciente', 'paciente', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.paciente.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }
public function updItem($data)
	{
        // set the variables from the passed data
        $id = $data['id'];
        $nombre = $data['nombre'];
		//$image = $data['image'];
        // set the data into a query to update the record
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
        $query->clear();
		$query->update(' #__tm_pacientes ');
		$query->set(' nombre = '.$db->Quote($nombre) );
		//$query->set(' image = '.$db->Quote($image) );
		$query->where(' id = ' . (int) $id );

		$db->setQuery((string)$query);

        if (!$db->query()) {
            JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
function store($data)
	{
		$row =& $this->getTable();

		if (!$row->bind($data)) {
			return false;
		}

		if (!$row->check()) {
			return false;
		}

		if (!$row->store()) {
			return false;
		}

		return true;
	}

/*
	protected function prepareTable(&$table)
        {
        $table->nombre = htmlspecialchars_decode($table->nombre, ENT_QUOTES);
		$table->direccion = JApplication::stringURLSafe($table->direccion);
		
        }
*/	
	

}

/*
	protected function prepareTable(&$table)
        {
        $table->nombre = htmlspecialchars_decode($table->nombre, ENT_QUOTES);
		$table->direccion = JApplication::stringURLSafe($table->direccion);
		
        }
*/	
	

}
