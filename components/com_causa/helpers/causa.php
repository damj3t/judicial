<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
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

class CausaHelper
{
        public static function addSubmenu($vName)
        {
		JSubMenuHelper::addEntry(
                        JText::_('COM_TECNOMED_SUBMENU_CPANEL'),
                        'index.php?option=com_causa&view=cpanel',
                        $vName == 'cpanel'
                );

        }

		function getlist_Causas($name = 'id_causa') {
		
		$user	 =& JFactory::getUser();
		
		$db = &JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select("c.id as id, CONCAT(cli.nombre,' ',c.rit) as title"); 
		$query->from(' #__sico_causas as  c');
		$query->join('#__sico_clientes cli on cli.id = c.id_cliente'); 
		$query->where('c.id_user = '.$user->id );

		$db->setQuery($query);

		//$rowsi[] = JHTML::_('select.option',  '0', '- '.JText::_( 'Sin Causas' ).' -', 'id', 'title' );
		$rows = $db->loadObjectList();
		//$rows = array_merge($rowsi, $rowsm);
		$list = JHTML::_('select.genericlist', $rows, $name, 'class="inputbox" size="1"', 'id', 'title', $id_causa);
		return $list;
	}      
	public static function getActions($pacienteid =0)
        {
                $user   = JFactory::getUser();
                $result = new JObject;

                if (empty($pacienteid) ) {
                        $assetName = 'com_causa';
                }
                

                $actions = array(
                        'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
                );

                foreach ($actions as $action) {
                        $result->set($action,   $user->authorise($action, $assetName));
                }

                return $result;
        }

		


		public static function sumaMes($fecha,$mes)//suma meses a la fecha que se pasa por parametro
		{	list($year,$mon) = explode('-',$fecha);
			return date('Y-m',mktime(0,0,0,$mon+$mes,1,$year));		
		}



		public static function nombreMes($num)
		{
			$array = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			return $array[$num];
		}

		public static function dia($numero)
		{
			if ($numero == 0){return "Domingo";}
			if ($numero == 1){return "Lunes";}
			if ($numero == 2){return "Martes";}
			if ($numero == 3){return "Miercoles";}
			if ($numero == 4){return "Jueves";}
			if ($numero == 5){return "Viernes";}
			if ($numero == 6){return "Sabado";}
		}

}
