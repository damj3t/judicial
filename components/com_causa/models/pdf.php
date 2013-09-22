
<?php
defined('_JEXEC') or die("Invalid access");
//jimport('joomla.application.component.model');
jimport('joomla.application.component.modelitem');

//class SophiaModelInfo extends JModel
class CausaModelPdf extends JModel
{


	public function getTable($type = 'atencion', $prefix = 'CausaTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	function __construct()
	{
		parent::__construct();
	}



	function getData()
	{
		$id = JRequest::getVar('id');


			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('ate.*');
			$query->select('pac.nombre AS nombre');
			$query->select('pac.rut AS rut');
			$query->select('pac.direccion AS direccion');
			$query->select('pac.telefono AS telefono');
			$query->select('pac.telefono AS telefono');
			$query->select('prof.nombre AS medico');
			$query->select('prof.rut AS rutmedico');
			$query->from( '#__tm_rce_atenciones AS ate ');
			$query->from( '#__tm_pacientes AS pac ');
			$query->from( '#__tm_diagnosticos AS diag ');
			$query->from( '#__tm_profesionales AS prof ');
			$query->where('pac.id = ate.pacienteid ');
			$query->where('diag.id = ate.diagnosticoid ');
			$query->where('prof.id = ate.profesional_id ');

			$query->where('ate.id = '. $id);


			$this->_db->setQuery($query);
			$this->atencion = $this->_db->loadObjectList();
	

		return $this->atencion;
	}

	function getRecetas()
	{
		$id = JRequest::getVar('id');


			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('trf.*');
			$query->select('pac.nombre AS nombre');
			$query->select('pac.rut AS rut');
			$query->select('pac.direccion AS direccion');
			$query->select('pac.telefono AS telefono');
			$query->select("CONCAT(tf.nombre,' ',tf.dosis) AS farmaco");
			$query->from( '#__tm_rce_farmacos AS trf ');
			$query->from( '#__tm_pacientes AS pac ');
			$query->from( '#__tm_farmacos AS tf ');
			$query->where('pac.id = trf.paciente_id ');
			$query->where('tf.id = trf.farmaco_id ');
			
			$query->where('trf.atencion_id = '. $id);


			$this->_db->setQuery($query);
			$this->atencion = $this->_db->loadObjectList();
	

		return $this->atencion;
	}

	 

}
?>