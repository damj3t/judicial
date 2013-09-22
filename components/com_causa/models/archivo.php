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

class CausaModelArchivo extends JModelAdmin
{
	protected $text_prefix = 'COM_CAUSA';



	public function getTable($type = 'Archivo', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }


	public function getScript() 
	{
		return 'administrator/components/com_causa/models/forms/archivo.js';
	}
	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.archivo', 'archivo', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.archivo.data', array());

                if (empty($data)) {
                        $data = $this->getItem();
                }

                return $data;
        }
		
		
		
		
 public function save($data)
	 {
	// if (parent::save($data)) {
			
		
			//$db = &JFactory::getDBO();
			//$newid = $db->insertid() ;
		    $newid = $data['id_causa'];
		    $tipo_doc=$data['id_tipo_documento'];
			$extracto=$data['extracto'];
			$id_user=$data['id_user'];
			
		    if(isset($_FILES['files'])){
			$errors= array();
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
				$file_name = $_FILES['files']['name'][$key];
				$file_size =$_FILES['files']['size'][$key];
				$file_tmp =$_FILES['files']['tmp_name'][$key];
				$file_type=$_FILES['files']['type'][$key];	
				$file_ext = end(explode(".", $_FILES["files"]["name"][$key]));
				
				if($file_size > 2097152){
					$errors[]='File size must be less than 2 MB';
				}		
					
				   $db = $this->getDbo();
					$db->setQuery(
						'insert into  #__sico_documentos (id_causa,nombre_doc,ruta_doc,extencion,id_tipo_documento,state,extracto,id_user)'
					   .'values ('.$newid.',"'.$file_name.'","'.$file_name.'","'.$file_ext.'",'.$tipo_doc.',1,"'.$extracto.'","'.$id_user.'")'
					  );
					if (!$db->query()) {
						throw new Exception($db->getErrorMsg());
					}
				$desired_dir=$newid;
				if(empty($errors)==true){
					if(is_dir($desired_dir)==false){
						mkdir("upload/$desired_dir", 0755);		// Create directory if it does not exist
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
		}

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

}
