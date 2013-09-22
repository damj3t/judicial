<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldCausa extends JFormFieldList
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
		$id_causa = JRequest::getVar('id_causa');
		// Construct the query

		//$query = $db->getQuery(true);
		$query->select("c.id as id, CONCAT(cli.nombre,' ',c.rit) as nombre"); 
		$query->from('#__sico_causas as  c');
		$query->from('#__sico_clientes cli');
		$query->where( 'cli.id = c.id_cliente'); 
		$query->where('c.id_user = '.$user->id );
		
		if ($id_causa > 0){
                $query->where('a.id_causa ='.$id_causa );
				}
		
		$db->setQuery((string)$query);
		$causas = $db->loadObjectList();
		$options = array();
		if ($causas)
		{
			foreach($causas as $causa) 
			{
				$options[] = JHtml::_('select.option', $causa->id, $causa->nombre );
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
