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

class CausaModelMensaje extends JModelAdmin
{
	protected $text_prefix = 'COM_CAUSA';



	public function getTable($type = 'Mensaje', $prefix = 'CausaTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }



	public function getForm($data = array(), $loadData = true)
        {
		$form = $this->loadForm('com_causa.mensaje', 'mensaje', array('control' => 'jform', 'load_data' => $loadData));
                if (empty($form)) {
                        return false;
                }

		return $form;
        }



	protected function loadFormData()
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_causa.edit.mensaje.data', array());
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
        $msg = $data['msg'];
        $tel = $data['tel'];
        $email = "damj3t@gmail.com";
        $pass = "14201998";
        
        $url =  "http://nodesms.aws.af.cm/admin/api/damj3t@gmail.com"; 
		$valor1 = "hola";
		$valor2 = "adi&oacute;s";
	    //{ email: "tu email" ,pass: "tu pass" ,tel: "destinatario" ,msg: "mensaje" ,nombre: "tu nombre" }
        $parametros_post = 'email='.urlencode($email).'&pass='.urlencode($pass).'&tel='.urlencode($tel).'&msg='.urlencode($msg).'&nombre='.urlencode($nombre);
        
        $sesion = curl_init($url);
		// definir tipo de petici&oacute;n a realizar: POST
		curl_setopt ($sesion, CURLOPT_POST, true); 
		// Le pasamos los par&aacute;metros definidos anteriormente
		curl_setopt ($sesion, CURLOPT_POSTFIELDS, $parametros_post); 
		// s&oacute;lo queremos que nos devuelva la respuesta
		curl_setopt($sesion, CURLOPT_HEADER, false); 
		curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
		// ejecutamos la petici&oacute;n
		$respuesta = curl_exec($sesion); 
		// cerramos conexi&oacute;n
		curl_close($sesion); 
        
        
		$db = $this->getDbo();
		$db->setQuery(
			'insert into  #__sico_mensajes (msg,nombre,tel)'
		   .'values ("'.$msg.'","'.$nombre.'","'.$tel.'")'
		  );
		if (!$db->query()) {
			throw new Exception($db->getErrorMsg());
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



}
