<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class CausaTableCliente extends JTable
{
	public function __construct(&$db)
        {
                parent::__construct('#__sico_clientes', 'id', $db);
        }

	function check()
        {
	/** check for valid name */
                if (trim($this->nombre) == '') {
                        $this->setError(JText::_('COM_TECNOMED_WARNING_VALIDAR_NOMBRE'));
                        return false;
                }

                return true;
        }

}
