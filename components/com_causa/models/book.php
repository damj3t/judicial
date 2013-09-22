<?php
/**
 * @package Joomla
 * @subpackage Tecnomed
 * @copyright (C) 2010 Ugolotti Federica
 * @license GNU/GPL, see LICENSE.php
 * Tecnomed is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Tecnomed is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Tecnomed; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');
jimport('joomla.application.categories');

class TecnomedModelBook extends JModelItem
{
	protected $_context = 'com_abook.book';
	//private $_parent = null;
        private $_categories = null;

	protected function populateState()
        {
                $app = JFactory::getApplication('site');

                // Load state from the request.
                $pk = JRequest::getInt('id');
                $this->setState('book.id', $pk);

                $offset = JRequest::getInt('limitstart');
                $this->setState('list.offset', $offset);

                // TODO: Tune these values based on other permissions.
                $this->setState('filter.published', 1);
//--------------------------------------------
		// Load the parameters dalla configurazione globale.
		$params = $app->getParams();
		$this->setState('params', $params);
//-------------------------------------------
        }


//funzione da rivedere, se la commenti il resto funziona, commentare anche il richiamo della funzione in view.html.php
	public function getCategories()
        {
		if(!count($this->_categories))
                {
                        $app = JFactory::getApplication();
                        $menu = $app->getMenu();
                        $active = $menu->getActive();
                        $params = new JRegistry();
                        if($active)
                        {
                                $params->loadJSON($active->params);
                        }
                        $options = array();
                        $options['countItems'] = $params->get('show_item_count', 0) || !$params->get('show_empty_categories', 0);
                        $categories = JCategories::getInstance('Tecnomed', $options);
//per recuperare il catid
//print_r($this->_item[$this->getState('book.id')]->catid);

                        $this->_parent = $categories->get($this->getState('filter.parentId'));
                        if(is_object($this->_parent))
                        {
                                $this->_categories = $this->_parent->getChildren();
                        } else {
                                $this->_categories = false;
                        }
                }
                return $this->_categories;

        }

	public function getCategory()
	{
		$categories = JCategories::getInstance('Tecnomed');
		$this->_category = $categories->get($this->_item[$this->getState('book.id')]->catid);
		return $this->_category;
	}

	public function getParent()
        {
                if(!is_object($this->_parent))
                {
                        //$this->getItems();
			$this->getCategories();
                }
                return $this->_parent;
        }

	public function &getAuthors($pk = null)
        {
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('book.id');
		if ($this->_item === null) {
                        $this->_authors = array();
                }

                if (!isset($this->_authors[$pk])) {
			try {
                                $db = $this->getDbo();
                                $query = $db->getQuery(true);

                                $query->select($this->getState('item.select', 'ab.*'));
                                $query->from('#__abbookauth AS ab');

				// Join on authors table.
                                $query->select('a.name AS author_name, a.id AS author_id, a.alias');
                                $query->join('LEFT', '#__abauthor AS a on a.id = ab.idauth');

				$query->where('ab.idbook = ' . (int) $pk);

				$db->setQuery($query);

                                $data = $db->loadObjectList();
                                if ($error = $db->getErrorMsg()) {
                                        throw new Exception($error);
                                }
				$this->_authors[$pk] = $data;
                        }
                        catch (JException $e)
                        {
                                $this->setError($e);
                                $this->_authors[$pk] = false;
                        }
                }
                return $this->_authors[$pk];
	}



        public function &getTags($pk = null)
        {
                $pk = (!empty($pk)) ? $pk : (int) $this->getState('book.id');
                if ($this->_item === null) {
                        $this->_tags = array();
                }

                if (!isset($this->_tags[$pk])) {
                        try {
                                $db = $this->getDbo();
                                $query = $db->getQuery(true);

                                $query->select($this->getState('item.select', 'ab.*'));
                                $query->from('#__abbooktag AS ab');

                                // Join on authors table.
                                $query->select('a.name AS tag_name, a.id AS tag_id, a.alias');
                                $query->join('LEFT', '#__abtag AS a on a.id = ab.idtag');

                                $query->where('ab.idbook = ' . (int) $pk);

                                $db->setQuery($query);

                                $data = $db->loadObjectList();
                                if ($error = $db->getErrorMsg()) {
                                        throw new Exception($error);
                                }
                                $this->_tags[$pk] = $data;
                        }
                        catch (JException $e)
                        {
                                $this->setError($e);
                                $this->_tags[$pk] = false;
                        }
                }
                return $this->_tags[$pk];
        }

	public function &getItem($pk = null)
        {
                // Initialise variables.
                $pk = (!empty($pk)) ? $pk : (int) $this->getState('book.id');

                if ($this->_item === null) {
                        $this->_item = array();
                }
                if (!isset($this->_item[$pk])) {
                        try {
                                $db = $this->getDbo();
                                $query = $db->getQuery(true);

                                $query->select($this->getState('item.select', 'a.*'));
                                $query->from('#__abbook AS a');

                                // Join on category table.
                                $query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access');
                                $query->join('LEFT', '#__abcategories AS c on c.id = a.catid');

				// Join on location table.
                                $query->select('l.name AS location_name');
                                $query->join('LEFT', '#__ablocations AS l on l.id = a.idlocation ');
				
				// Join on editor table.
                                $query->select('e.name AS editor_name');
                                $query->join('LEFT', '#__abeditor AS e on e.id = a.ideditor ');

				// Join on editor table.
                                $query->select('li.name AS library_name');
                                $query->join('LEFT', '#__ablibrary AS li on li.id = a.idlibrary ');

                                // Join on user table.
                                $query->select('u.name AS written_by');
                                $query->join('LEFT', '#__users AS u on u.id = a.user_id');

                                // Join over the categories to get parent category titles
                                $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias');
                                $query->join('LEFT', '#__abcategories as parent ON parent.id = c.parent_id');

                                $query->where('a.id = ' . (int) $pk);

                                // Filter by published state.
                                $published = $this->getState('filter.published');
                                if (is_numeric($published)) {
                                        $query->where('(a.published = ' . (int) $published. ')');
                                }

                                $db->setQuery($query);

                                $data = $db->loadObject();
				if ($error = $db->getErrorMsg()) {
                                        throw new Exception($error);
                                }

                                if (empty($data)) {
                                        JError::raiseError(404, JText::_('COM_ABOOK_ERROR_BOOK_NOT_FOUND'));
                                }

                                // Check for published state if filter set.
                                if (((is_numeric($published)) || (is_numeric($archived))) && (($data->published != $published) ))
                                {
                                        JError::raiseError(404, JText::_('COM_ABOOK_ERROR_BOOK_NOT_FOUND'));
                                }
		//----------------------------------------------------------
				// Load the JSON string parametri del libro
				$params = new JRegistry;
				$params->loadJSON($data->params);
				$data->params = $params;
				// Merge global params with item params vince il libro
				$params = clone $this->getState('params');
				$params->merge($data->params);
				$data->params = $params;
				//i paramtri del menu vengono sovrascritti nel view.html.php 
		//----------------------------------------------------------

                                $this->_item[$pk] = $data;
                        }
			catch (JException $e)
                        {
                                $this->setError($e);
                                $this->_item[$pk] = false;
                        }
                }

                return $this->_item[$pk];
        }

	function &getVoting()
        {
                if (empty($this->_voting)){
                        $query='SELECT ROUND( v.rating_sum / v.rating_count ) AS rating, v.rating_count'
                                .' FROM #__abbook AS a'
                                .' LEFT JOIN #__abrating AS v ON a.id = v.book_id'
                                .' WHERE a.id='. (int) $this->getState('book.id');
                        $this->_db->setQuery($query);
                        $this->_voting = $this->_db->loadAssoc();
                }
                return $this->_voting;
        }

	public function getTable($type = 'Book', $prefix = 'TecnomedTable', $config = array())
        {
                return JTable::getInstance($type, $prefix, $config);
        }

	public function storeVote($pk = 0, $rate = 0) {
		if ( $rate >= 1 && $rate <= 5 && $pk > 0 ) {
            		$userIP = $_SERVER['REMOTE_ADDR'];
            		$db = $this->getDbo();

            		$db->setQuery(
				'SELECT *' .
				' FROM #__abrating' .
				' WHERE book_id = '.(int) $pk
			);

            		$rating = $db->loadObject();

            		if (!$rating){
		                // There are no ratings yet, so lets insert our rating
                		$db->setQuery(
                        		'INSERT INTO #__abrating ( book_id, lastip, rating_sum, rating_count )' .
                        		' VALUES ( '.(int) $pk.', '.$db->Quote($userIP).', '.(int) $rate.', 1 )'
                		);

                		if (!$db->query()) {
                        		$this->setError($db->getErrorMsg());
                        		return false;
                		}
            		} else {
				if ($userIP != ($rating->lastip)){
                    			$db->setQuery(
                            			'UPDATE #__abrating' .
                            			' SET rating_count = rating_count + 1, rating_sum = rating_sum + '.(int) $rate.', lastip = '.$db->Quote($userIP) .
                            			' WHERE book_id = '.(int) $pk
                    			);
                    			if (!$db->query()) {
                            			$this->setError($db->getErrorMsg());
                            			return false;
                    			}
                		} else {
                    			return false;
                		}
            		}
            		return true;
        	}
        	JError::raiseWarning( 'SOME_ERROR_CODE', JText::sprintf('COM_CONTENT_INVALID_RATING', $rate), "JModelArticle::storeVote($rate)");
        	return false;
    	}

	//incrementare il numero delle visite	
	public function hit($id = null)
        {
                if (empty($id)) {
                        $id = $this->getState('book.id');
                }

                $book = $this->getTable();
                return $book->hit($id);
        }
}
