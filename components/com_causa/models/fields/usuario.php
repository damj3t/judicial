<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldUsuario extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Usuario';
 
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
		$query->select("c.id as id, abo.nombre as nombre"); 
		$query->from('#__users as  c');
		$query->from('#__sico_abogados as  abo');
		
		$query->where('abo.id_user = c.id ');
		$query->where('c.id = '.$user->id );
		
		
		$db->setQuery((string)$query);
		$usuarios = $db->loadObjectList();
		$options = array();
		if ($usuarios)
		{
			foreach($usuarios as $usuario) 
			{
				$options[] = JHtml::_('select.option', $usuario->id, $usuario->nombre );
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
