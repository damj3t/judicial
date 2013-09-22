<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldCliente extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'cliente';
 
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
		$id_client = JRequest::getVar('id_client');		
		// Construct the query

		//$query = $db->getQuery(true);
		$query->select("c.id as id, c.nombre as nombre"); 
		$query->from('#__sico_cliente as  c');
		
		if ($id_client > 0){
                $query->where('c.id ='.$id_client );
				}
		
				$query->where('c.id_user = '.$user->id );
		
		
		$db->setQuery((string)$query);
		$clientes = $db->loadObjectList();
		$options = array();
		if ($clientes)
		{
			foreach($clientes as $cliente) 
			{
				$options[] = JHtml::_('select.option', $cliente->id, $cliente->nombre );
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
