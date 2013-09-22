<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
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
