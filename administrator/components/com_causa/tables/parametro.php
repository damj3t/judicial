<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class CausaTableParametro extends JTable
{
	public function __construct(&$db)
        {
                parent::__construct('#__sico_paramet', 'id', $db);
        }

	function check()
        {
	/** check for valid name */
                if (trim($this->desc_item) == '') {
                        $this->setError(JText::_('COM_TECNOMED_WARNING_VALIDAR_NOMBRE'));
                        return false;
                }

                return true;
        }

}
?>