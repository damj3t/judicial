<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modeladmin');

class CausaModelAudiencia extends JModelAdmin
{
	protected $text_prefix = 'COM_CAUSA';



	public function getTable($type = 'Audiencia', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }


	public function getScript() 
	{
		return 'administrator/components/com_causa/models/forms/audiencia.js';
	}
	public function getForm($data = array(), $loadData = true)
        {
        //$id_causa = JRequest::getVar('id_causa');
		$form = $this->loadForm('com_causa.audiencia', 'audiencia', array('control' => 'jform', 'load_data' => $loadData));
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
                $data = JFactory::getApplication()->getUserState('com_causa.edit.audiencia.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }
        
public  function getCausa()
        {
			$id_causa = JRequest::getVar('id_causa');
			return $this->id_causa;
			
        }
public function updItem($data)
	{
        // set the variables from the passed data
        $id = $data['id'];
        $fecha = $data['fecha_audiencia'];

        // set the data into a query to update the record
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
        $query->clear();
		$query->update(' #__sico_audiencias ');
		$query->set(' fecha_audiencia = '.$db->Quote($fecha) );
		
		$query->where(' id = ' . (int) $id );

		$db->setQuery((string)$query);

        if (!$db->query()) {
            JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
	

public function getCausas() {
		// Create a new query object.
		$db = $this->getDbo();
		$id_causa = JRequest::getVar('id_causa');
		$query = $db->getQuery(true);
		
		$user	 =& JFactory::getUser();	
		// Construct the query

		//$query = $db->getQuery(true);
		$query->select("c.id as id, CONCAT(cli.nombre,' ',c.rit) as nombre"); 
		$query->from('#__sico_causas as  c');
		$query->from('#__sico_clientes cli');
		$query->where( 'cli.id = c.id_cliente'); 
		$query->where('c.id_user = '.$user->id );
		$query->where ('c.id =' .$id_causa);
		
		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}

function getlistCausas($name = 'id_causa') {
		
		$user	 =& JFactory::getUser();
		
		$db = &JFactory::getDBO();
		
		$query = $db->getQuery(true);
		//$query = $db->getQuery(true);
		$query->select("c.id as id_causa, CONCAT(cli.nombre,' ',c.rit) as nombre"); 
		$query->from('#__sico_causas as  c');
		$query->from('#__sico_clientes cli');
		$query->where( 'cli.id = c.id_cliente'); 
		$query->where('c.id_user = '.$user->id );
		

		$db->setQuery($query);

		$rowsi[] = JHTML::_('select.option',  '0', '- '.JText::_( 'Sin Causas' ).' -', 'id_causa', 'nombre' );
		$rowsm = $db->loadObjectList();
		$rows = array_merge($rowsi, $rowsm);
		$list = JHTML::_('select.genericlist', $rows, 'id_causa', 'class="inputbox" size="1"', 'id_causa', 'nombre', 0);
		return $list;
	}
	
}
