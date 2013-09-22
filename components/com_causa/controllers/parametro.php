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

class CausaControllerParametro extends JControllerForm
{
	protected function allowAdd($data = array())
        {
                // Initialise variables.
                $user           = JFactory::getUser();
                $allow          = null;

                if ($allow === null) {
                        // In the absense of better information, revert to the component permissions.
                        return parent::allowAdd($data);
                } else {
                        return $allow;
                }
        }

	protected function allowEdit($data = array(), $key = 'id')
        {
 		      return parent::allowEdit($data, $key);
        
        }
function guardar()
	{

		$model = $this->getModel( 'parametro' );
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		
		if ($model->store($data)) {

			echo "<h2>Guardado Correctamente</h2>";
		} else {
			 echo "<h2>Registro no Guardado, Reintente</h2>";
		}
		return true;
	}
	        
}
