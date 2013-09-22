<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class CausaModelAdmin extends JModelList
{
	public function getBotones() {

	
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('bot.*');
			$query->from( '#__sico_botones AS bot');
			$query->where('bot.menu = 1');
			$query->where('bot.published = 1');
			$query->order('bot.id');

			$this->_db->setQuery($query);
			$this->admin = $this->_db->loadObjectList();
		

		return $this->admin;
	}

}	
