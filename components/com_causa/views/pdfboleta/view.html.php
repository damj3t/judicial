
<?php
defined( '_JEXEC') or die( 'Restricted access');
jimport( 'joomla.application.component.view');

class CausaViewPdfboleta extends JView
{


	function display($tpl = null)
	{
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		//jimport('joomla.html.pane');

		$model =& $this->getModel();

		$this->ficha =& $this->get( 'Data');
		$user	= JFactory::getUser();


		parent::display($tpl);
	}

}

?>