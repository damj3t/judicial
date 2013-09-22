<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modeladmin');

class CausaModelAbogado extends JModelAdmin
{
	protected $text_prefix = 'COM_CAUSA';



	public function getTable($type = 'Abogado', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }



	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.abogado', 'abogado', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
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
	
	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.abogado.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }

/*
	protected function prepareTable(&$table)
        {
        $table->nombre = htmlspecialchars_decode($table->nombre, ENT_QUOTES);
		$table->direccion = JApplication::stringURLSafe($table->direccion);
		
        }
*/	
	

}
