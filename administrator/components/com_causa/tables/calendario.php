<?php
//----------------------------------------------------------------------
// Sophia
// Sophia by Alex Olave - http://www.alfazeta.cl
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Author: 	Alex Olave - http://www.alfazeta.cl
// Copyright: copyright (C) 2012 - Alex Olave.
// License: 	GNU/GPL, http://www.gnu.org/copyleft/gpl.html
// Pack: 	Sophia
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Sophia is free software. This version may have been modified pursuant
// to the GNU General Public License, and as distributed it includes or
// is derivative of works licensed under the GNU General Public License or
// other free or open source software licenses.
//----------------------------------------------------------------------


defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla table library
jimport('joomla.database.table');


/*
 tabla definada para el ingreso de los datos del alumno
 */

class CausaTablecalendario extends JTable{


	function __construct( &$db )
	{
		parent::__construct( '#__tm_agenda_det', 'id', $db );

	}// function

}


