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

jimport('joomla.application.component.controllerform');

class CausaControllerCausa extends JControllerForm
{
public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
  /*   function save()
	{

		//$post	= JRequest::get('post');
		$model = $this->getModel( 'causa' );
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		
		//$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		//$post['id'] 	= (int) $cid[0];

		
		if ($model->store($data)) {
			$msg = JText::_( 'Registro Guardado' );
		} else {
			$msg = JText::_( 'Error al Guardar Registro' );
		}

		$link = 'index.php?option=com_causa&view=causas';
		$this->setRedirect( $link, $msg );
	}
	*/
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('causa');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

        // Now update the loaded data to the database via a function in the model
        $upditem	= $model->updItem($data);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.
        if ($upditem) {
            echo "<h2>Guardado Correctamente</h2>";
        } else {
            echo "<h2>Actualizado Correctamente</h2>";
        }

		return true;
	}
}
