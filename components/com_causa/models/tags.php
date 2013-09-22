<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class TecnomedModelTags extends JModelList
{
	protected $_item = null;

	/**
	 * Method to get a list of items.
	 *
	 * @return	mixed	An array of objects on success, false on failure.
	 */
//questa funzione contiene i libri che risultano dalla query più in basso, si può anche non mettere, la lascio perchè se voglio fare una variazione alla funzione di default basta che scrivo cose dopo $items = &parent::getItems(); facendo un ciclo for per tutti gli items
	public function &getItems()
	{
		// Invoke the parent getItems method to get the main list
		$items = &parent::getItems();
		for ($i = 0, $n = count($items); $i < $n; $i++) {
                        $item = &$items[$i];
			$this->_tagname($item->id);
                        $item->tags=$this->_tagname;
                }
		return $items;
	}

	//query che tira fuori i libri di una categoria che vengono messi nel risultato della funzione getItems
	protected function getListQuery()
	{
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels());

		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select required fields from the categories.
		$query->select($this->getState('list.select', '*'));
		$query->from('`#__abtag_groups` AS a');

		// Filter by language
		if ($this->getState('filter.language')) {
			$query->where('language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		}

		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'name')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		return $query;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Initialise variables.
		$app    = JFactory::getApplication('site');

                // Load the parameters
                $params = $app->getParams();
		$menuParams = new JRegistry;

                if ($menu = $app->getMenu()->getActive()) {
                        $menuParams->loadString($menu->params);
                }

                $mergedParams = clone $menuParams;
                $mergedParams->merge($params);
                $this->setState('params', $mergedParams);

		// List state information
		$limit = $app->getUserStateFromRequest('abook.category.list.limit', 'limit', $params->get('bookpagination'));
		$this->setState('list.limit', $limit);

		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$this->setState('list.start', $limitstart);

		$orderCol	= JRequest::getCmd('filter_order', 'name');
		$this->setState('list.ordering', $orderCol);

		$listOrder	=  JRequest::getCmd('filter_order_Dir', $params->get('books_display_order_dir','ASC'));
		$this->setState('list.direction', $listOrder);

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setState('category.id', $id);

		$this->setState('filter.published',	1);

		$this->setState('filter.language',$app->getLanguageFilter());
	}

	protected function _Tagname($idtaggroup)
        {
                // Lets load the content if it doesn't already exist
                $query = 'SELECT *' .
                         ' FROM #__abtag'.
                         ' WHERE id_taggroup = '. (int) $idtaggroup;
                $this->_db->setQuery($query);
                $this->_tagname = $this->_db->loadObjectList();
                return $this->_tagname;
        }
}
