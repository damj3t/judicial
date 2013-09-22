<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class TecnomedModelTag extends JModelList
{
	protected $_item = null;
	protected $_tag = null;
//questa funzione contiene i libri che risultano dalla query più in basso, si può anche non mettere, la lascio perchè se voglio fare una variazione alla funzione di default basta che scrivo cose dopo $items = &parent::getItems(); facendo un ciclo for per tutti gli items
	public function &getItems()
	{
		// Invoke the parent getItems method to get the main list
		$items = &parent::getItems();
		for ($i = 0, $n = count($items); $i < $n; $i++) {
                        $item = &$items[$i];
                        $this->_authorname($item->id);
                        $item->authors=$this->_authorname;
			$this->_tagname($item->id);
                        $item->tags=$this->_tagname;
			$this->_voting($item->id);
                        $item->vote=$this->_voting;
                }
		return $items;
	}

	//query che tira fuori i libri di una categoria che vengono messi nel risultato della funzione getItems
	protected function getListQuery()
	{
		$user   = JFactory::getUser();
                $groups = implode(',', $user->authorisedLevels());

                // Create a new query object.
                $db             = $this->getDbo();
                $query  = $db->getQuery(true);

                // Select required fields from the categories.
                $query->select($this->getState('list.select', 'a.*'));
                $query->from('`#__abbook` AS a');
                $query->where('a.access IN ('.$groups.')');

                // Filter by category.
			$query->select('c.title AS cattitle, c.alias AS catalias');
                        $query->join('LEFT', '#__abcategories AS c ON c.id = a.catid');
                        $query->where('c.access IN ('.$groups.')');
                $query->join('LEFT', '#__abbooktag AS aa ON aa.idbook = a.id');
		$query->where('aa.idtag ='.$this->getState('tag.id'));
                // Filter by state
                $query->where('a.published = 1');
                // Filter by start and end dates.
                $nullDate = $db->Quote($db->getNullDate());
                $nowDate = $db->Quote(JFactory::getDate()->toMySQL());

                // Filter by language
                if ($this->getState('filter.language')) {
                        $query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		}

		// Add the list ordering clause.
		$query->order($db->getEscaped($this->getState('list.ordering', 'a.ordering')).' '.$db->getEscaped($this->getState('list.direction', 'ASC')));

		$query->group('a.id');

		return $query;
	}

	protected function _Authorname($idbook)
        {
                // Lets load the content if it doesn't already exist
                $query = 'SELECT a.name AS author, a.id AS idauthor' .
                         ' FROM #__abbookauth AS b'.
                         ' JOIN #__abauthor AS a ON a.id = b.idauth' .
                         ' WHERE b.idbook = '. (int) $idbook;
                $this->_db->setQuery($query);
                $this->_authorname = $this->_db->loadObjectList();
                return $this->_authorname;
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

                // Load the parameters. Merge Global and Menu Item params into new object
                $params = $app->getParams();
                $menuParams = new JRegistry;

                if ($menu = $app->getMenu()->getActive()) {
                        $menuParams->loadString($menu->params);
                }
                $mergedParams = clone $menuParams;
                $mergedParams->merge($params);
		// Load the parameters.
                $this->setState('params', $mergedParams);

		// List state information
		$limit = $app->getUserStateFromRequest('abook.tag.list.limit', 'limit', $params->get('bookpagination'));
		$this->setState('list.limit', $limit);

		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$this->setState('list.start', $limitstart);

		$orderCol	= JRequest::getCmd('filter_order', $params->get('display_order','ordering'));
		$this->setState('list.ordering', $orderCol);

		$listOrder	=  JRequest::getCmd('filter_order_Dir', $params->get('books_display_order_dir','ASC'));
		$this->setState('list.direction', $listOrder);

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setState('tag.id', $id);

		$this->setState('filter.published',	1);

		$this->setState('filter.language',$app->getLanguageFilter());
	}

	/**
	 * Method to get tag data for the current tag
	 *
	 * @param	int		An optional ID
	 *
	 * @return	object
	 * @since	1.5
	 */
	public function getTag()
	{
                if (!is_object($this->_item)) {
                        if( isset( $this->state->params ) ) {
                                $params = $this->state->params;
                                $options = array();
                                $options['countItems'] = $params->get('show_item_count', 0);
                        }
                        else {
                                $options['countItems'] = 0;
                        }
                $query = 'SELECT *' .
                         ' FROM #__abtag'.
                         ' WHERE id = '. (int) $this->getState('tag.id');
                $this->_db->setQuery($query);
                $this->_item = $this->_db->loadObject();


                }
                return $this->_item;
	}

	        protected function _Tagname($idbook)
        {
                // Lets load the content if it doesn't already exist
                $query = 'SELECT a.name AS tag, a.id AS idtag, a.alias' .
                         ' FROM #__abbooktag AS b'.
                         ' JOIN #__abtag AS a ON a.id = b.idtag' .
                         ' WHERE b.idbook = '. (int) $idbook;
                $this->_db->setQuery($query);
                $this->_tagname = $this->_db->loadObjectList();
                return $this->_tagname;
        }

	function _Voting($idbook)
        {
                $query='SELECT ROUND( v.rating_sum / v.rating_count ) AS rating, v.rating_count'
                        .' FROM #__abbook AS a'
                        .' LEFT JOIN #__abrating AS v ON a.id = v.book_id'
                        .' WHERE a.id='. (int) $idbook;
                $this->_db->setQuery($query);
                $this->_voting = $this->_db->loadAssoc();
                return $this->_voting;
        }
}
