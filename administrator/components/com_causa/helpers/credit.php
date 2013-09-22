<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class JHTMLCredit
{
        function credit()
        {
		$xmldata = JApplicationHelper::parseXMLInstallFile(JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_causa'.DS.'causas.xml');
		$credit='<div style="text-align:center;"><a href="http://www.systemed.cl" target="_blank">Causa -Sistema Clinico '.$xmldata['version'].'</a></div><br />';
                return $credit;
        }
}
