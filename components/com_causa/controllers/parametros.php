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

jimport('joomla.application.component.controlleradmin');

class CausaControllerParametros extends JControllerAdmin
{
        public function &getModel($name = 'Parametro', $prefix = 'CausaModel')
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
}
function save()
	{


		$model = $this->getModel( 'parametro' );
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		
			
		if ($model->store($data)) {
			$msg = JText::_( 'Parametro Grabado' );
		} else {
			$msg = JText::_( 'Error Al Grabar el Parametro' );
		}

		$link = 'index.php?option=com_causa&view=parametros';
		$this->setRedirect( $link, $msg );
	}