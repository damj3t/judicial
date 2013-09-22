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

jimport( 'joomla.application.component.modellist' );

class CausaModelCpanel extends JModelList
{

	public function &getButtons()
        {
                if (empty($this->_buttons)) {
                        $this->_buttons = array(
				array(
                                        'link' => JRoute::_('index.php?option=com_causa&task=paciente.add'),
                                        'image' => 'tecnomed-pacientesadd-48.png',
                                        'text' => JText::_('COM_TECNOMED_PACIENTE_NUEVO'),
                                        'access' => array('core.admin', 'com_causa')
                      ),
                array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=pacientes'),
                                        'image' => 'tecnomed-pacientes-48.png',
                                        'text' => JText::_('COM_TECNOMED_PACIENTES'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&task=agenda.add'),
                                        'image' => 'tecnomed-agenda-48.png',
                                        'text' => JText::_('COM_TECNOMED_AGENDA'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=agendas'),
                                        'image' => 'tecnomed-agenda-48.png',
                                        'text' => JText::_('COM_TECNOMED_AGENDA'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=profesionals'),
                                        'image' => 'tecnomed-medico-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO'),
                                        'access' => array('core.admin', 'com_causa')
                     )
					 ,
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&task=profesional.add'),
                                        'image' => 'tecnomed-medicoadd-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO_NUEVO'),
                                        'access' => array('core.admin', 'com_causa')
                     ) ,
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&task=diagnostico.add'),
                                        'image' => 'tecnomed-main-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO_NUEVO'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=diagnosticos'),
                                        'image' => 'tecnomed-main-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=farmacos'),
                                        'image' => 'tecnomed-main-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO'),
                                        'access' => array('core.admin', 'com_causa')
                     ) ,
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&task=farmaco.add'),
                                        'image' => 'tecnomed-main-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO_NUEVO'),
                                        'access' => array('core.admin', 'com_causa')
                     ),
					 array(
                                        'link' => JRoute::_('index.php?option=com_causa&view=calendarios'),
                                        'image' => 'tecnomed-main-48.png',
                                        'text' => JText::_('COM_TECNOMED_MEDICO'),
                                        'access' => array('core.admin', 'com_causa')
                     )
                  );
                }

                return $this->_buttons;
        }



}	
