<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldAbogado extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'causa';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$user	 =& JFactory::getUser();	
		// Construct the query

		//$query = $db->getQuery(true);
		$query->select("c.id as id, c.nombre as nombre"); 
		$query->from('#__sico_abogados as  c');
		$query->where('c.id_user = '.$user->id );
		
		
		$db->setQuery((string)$query);
		$abogados = $db->loadObjectList();
		$options = array();
		if ($abogados)
		{
			foreach($abogados as $abogado) 
			{
				$options[] = JHtml::_('select.option', $abogado->id, $abogado->nombre );
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
