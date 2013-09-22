<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class CausaTableCausa extends JTable
{
	public function __construct(&$db)
        {
                parent::__construct('#__sico_causas', 'id', $db);
        }

	function check()
        {
	/** check for valid name */
                if (trim($this->rit) == '') {
                        $this->setError(JText::_('COM_CAUSA_WARNING_VALIDAR_NOMBRE'));
                        return false;
                }

                return true;
        }

}
