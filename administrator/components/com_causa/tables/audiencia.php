<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class CausaTableAudiencia extends JTable
{
	public function __construct(&$db)
        {
                parent::__construct('#__sico_audiencias', 'id', $db);
        }

	/*function check()
        {

                if (trim($this->id_causa) == '') {
                        $this->setError(JText::_('Debe Selecionar una Causa'));
                        return false;
                }

                return true;
        }*/

}
