
<?php
defined( '_JEXEC') or die( 'Restricted access');
jimport( 'joomla.application.component.view');

class CausaViewPdf extends JView
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
		$this->Medicamentos =& $this->get( 'Recetas');
/*
		$alumno		= & $model->getAlumno($matricula->id);

*/

		$user	= JFactory::getUser();


		parent::display($tpl);
	}

}

?>