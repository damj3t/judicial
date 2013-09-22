<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

class CausaControllerMensaje extends JControllerForm
{
public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('mensaje');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

        // Now update the loaded data to the database via a function in the model
        $upditem	= $model->updItem($data);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.
        if ($upditem) {
            $msg = JText::_( 'Mensaje Enviado' );
        } else {
        	$msg = JText::_( 'El mensaje no se ha enviado Intente Mas Tarde' );
        }
        
        $link = 'index.php?option=com_causa&view=causas';
		$this->setRedirect( $link, $msg );

		return true;
	}
}
