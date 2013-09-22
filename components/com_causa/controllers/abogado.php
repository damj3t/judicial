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

class CausaControllerAbogado extends JControllerForm
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
        
 function save()
	{

		//$post	= JRequest::get('post');
		$model = $this->getModel( 'abogado' );
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		
		//$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		//$post['id'] 	= (int) $cid[0];

		
		if ($model->store($data)) {
			$msg = JText::_( 'Abogado Guardado' );
			
		} else {
			$msg = JText::_( 'Error al Guardar al Abogado' );
		}

		$link = 'index.php?option=com_causa&view=abogados';
		$this->setRedirect( $link, $msg );
	 }
	 
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( JRoute::_('index.php?option=com_causa&view=abogados'), $msg );
	}
}
