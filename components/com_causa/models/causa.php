<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modeladmin');

class CausaModelCausa extends JModelAdmin
{
	protected $text_prefix = 'COM_CAUSA';



	public function getTable($type = 'Causa', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }


	public function getScript() 
	{
		return 'administrator/components/com_causa/models/forms/causa.js';
	}
	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.causa', 'causa', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.causa.data', array());

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
		$user	 =& JFactory::getUser();
        $db		= $this->getDbo();
		$query	= $db->getQuery(true);
        $query->clear();
		$query->update(' #__sico_causas ');
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
/*	
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
*/
	 public function save($data)
	 {
	 if (parent::save($data)) {
			
			$user	 =& JFactory::getUser();
	 		$id =$data['id'];
			$fecha_juicio =$data['fecha_juicio'];
			$hora_juicio =  $data['hora_juicio'];
			$edificio_juicio =$data['edificio_juicio'];
			$sala_juicio=$data['sala_juicio'];
			$fecha_preparatoria = $data['fecha_preparatoria'];
			$hora_preparatoria = $data['hora_preparatoria'];
			$edificio_preparatoria =$data['edificio_preparatoria'];
			$sala_preparatoria=$data['sala_preparatoria'];
			
			$tipo_doc=$data['id_tipo_documento'];
	 		$db = &JFactory::getDBO();
			$newid = $db->insertid() ;
			
			
		 	$db		= $this->getDbo();
			$query	= $db->getQuery(true);
			
	        $query->clear();
			$query->update(' #__sico_causas ');
			$query->set(' id_user = '.$user->id );
			$query->where(' id = ' . $id . ' or id ='. $newid );
	
			$db->setQuery((string)$query);
	
	        if (!$db->query()) {
	            JError::raiseError(500, $db->getErrorMsg());
	        	return false;
	        } //else {
	       // 	return true;
		//	}
			
		if ($id==0) { 	
	 		if ($fecha_preparatoria != '') {		
				$db = $this->getDbo();
				$db->setQuery(
					'insert into  #__sico_audiencias (id_causa,fecha_audiencia,hora,edificio,sala,motivo,state)'
				   .'values ('.$newid.',"'.$fecha_preparatoria.'","'.$hora_preparatoria.'","'.$edificio_preparatoria.'","'.$sala_preparatoria.'","Audiencia Preparatoria",1)'
				  );
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
	 		}	
	 		if ($fecha_juicio != '') {
	 			
	 			$db = $this->getDbo();
				$db->setQuery(
					'insert into  #__sico_audiencias (id_causa,fecha_audiencia,hora,edificio,sala,motivo,state)'
				   .'values ('.$newid.',"'.$fecha_juicio.'","'.$hora_juicio.'","'.$edificio_juicio.'","'.$sala_juicio.'","Audiencia de Juicio",1)'
				  );
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}		
		/*	
			//$tipo_doc = $data['id_tipo_documento'];
			if(isset($_FILES['files'])){
			$errors= array();
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
				$file_name = $key.$_FILES['files']['name'][$key];
				$file_size =$_FILES['files']['size'][$key];
				$file_tmp =$_FILES['files']['tmp_name'][$key];
				$file_type=$_FILES['files']['type'][$key];	
				//$file_ext =  substr(strrchr($file_name, '.'), 1);
				
				$file_ext = end(explode(".", $_FILES["files"]["name"][$key]));
				
				//print_r($file_ext);
				
				if($file_size > 2097152){
					$errors[]='File size must be less than 2 MB';
				}		
				
				   $db = $this->getDbo();
					$db->setQuery(
						'insert into  #__sico_documentos (id_causa,nombre_doc,ruta_doc,extencion,id_tipo_documento,state)'
					   .'values ('.$newid.',"'.$file_name.'","'.$file_name.'","'.$file_ext.'",'.$tipo_doc.',1)'
					  );
					if (!$db->query()) {
						throw new Exception($db->getErrorMsg());
					}
				$desired_dir=$newid;
				if(empty($errors)==true){
					if(is_dir($desired_dir)==false){
						mkdir("upload/$desired_dir", 0700);		// Create directory if it does not exist
					}
					if(is_dir("$desired_dir/".$file_name)==false){
						move_uploaded_file($file_tmp,"upload/$desired_dir/".$file_name);
					}else{									// rename the file if another one exist
						$new_dir="$desired_dir/".$file_name.time();
						 rename($file_tmp,$new_dir) ;				
					}
				 mysql_query($query);			
				}else{
						print_r($errors);
				}
			}
			if(empty($error)){
				return true;
			}
		}*/
	  		 return true;
		}	
	    return true;
	 }
	
 }

 public function extension($filename){
        $ext= substr(strrchr($filename, '.'), 1);
   return $ext;
 }

}
