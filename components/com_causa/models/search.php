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

jimport('joomla.application.component.modellist');

class TecnomedModelSearch extends JModelList 
{
        var $_data = null;
	var $_total = null;
	var $_pagination = null;

	function __construct()
	{
		parent::__construct();

                //Get configuration
		$app    = &JFactory::getApplication();
		// Load the parameters. Merge Global and Menu Item params into new object
                $config = $app->getParams();
                $menuParams = new JRegistry;

                if ($menu = $app->getMenu()->getActive()) {
                        $menuParams->loadString($menu->params);
                }
                $mergedParams = clone $menuParams;
                $mergedParams->merge($config);
		$this->config=$config;

		$this->setState('limit', $app->getUserStateFromRequest('com_abook.limit', 'limit', $this->config->get('bookpagination', 5), 'int'));
                $this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
                // Set the search parameters
                $keyword                = urldecode(JRequest::getString('keyword'));
		if(isset($keyword)) {
                        $this->setState('keyword', $keyword);
                }
		$category = JRequest::getVar('category');
		if(isset($category)) {
			$this->setState('category', $category);
		}
		$location = JRequest::getVar('location');
		if(isset($location)) {
                        $this->setState('location', $location);
                }
		$author = JRequest::getVar('author');
                if(isset($author)) {
                        $this->setState('author', $author);
                }
		$ideditor = JRequest::getVar('ideditor');
		if(isset($ideditor)) {
                        $this->setState('ideditor', $ideditor);
                }
		$author = JRequest::getVar('author');
		if(isset($author)) {
                        $this->setState('author', $author);
                }
		$year = JRequest::getVar('year');
		if(isset($year)) {
                        $this->setState('year', $year);
                }
		$library = JRequest::getVar('library');
		if(isset($library)) {
                        $this->setState('library', $library);
                }
	}

	function getKey()
        {
		$searchparam = null;
		if (($this->getState('keyword'))!=''){
                        $searchparam['keyword']= $this->getState('keyword');
			$searchparamid['keyword']= "((a.title LIKE '%" .$this->getState('keyword') ."%') OR (a.subtitle LIKE '%" .$this->getState('keyword') ."%') OR (a.description LIKE '%" .$this->getState('keyword') ."%') OR (cat.title LIKE '%" .$this->getState('keyword') ."%') OR (a.catalogo LIKE '%" .$this->getState('keyword') ."%'))";
                }
                if (($this->getState('category'))!=''){
                        $searchparam['category']=$this->getState('category');
			$searchparamid['category']="catid=" .$this->getState('category');
		}
                if (($this->getState('location'))!=''){
                        $searchparam['location']=$this->getState('location');
			$searchparamid['location']="idlocation=" .$this->getState('location');
                }
		if (($this->getState('author'))!=''){
                        $searchparam['author']=$this->getState('author');
                        $searchparamid['author']="idauth=" .$this->getState('author');
                }
                if (($this->getState('ideditor'))!=''){
                        $searchparam['ideditor']=$this->getState('ideditor');
			$searchparamid['ideditor']="ideditor=" .$this->getState('ideditor');
                }
                if (($this->getState('year'))!=''){
                        $searchparam['year']=$this->getState('year');
			$searchparamid['year']="year=" .$this->getState('year');
                }
                if (($this->getState('library'))!=''){
                        $searchparam['library']=$this->getState('library');
			$searchparamid['library']="idlibrary=" .$this->getState('library');
		}
		if(isset($searchparamid)) {
                        $this->setState('searchparamid', $searchparamid);
                }
		return $searchparam;
        }

	function _buildQuery()
	{
		//$user           =& JFactory::getUser();
		$user   = JFactory::getUser();
                $groups = implode(',', $user->authorisedLevels());
		$where=$this->getState('searchparamid');
		if ($this->config->get('catid') >0) {
	                $where[] = "a.catid IN (".$this->config->get('catid') .") ";
		}
		$where[]="a.published=1";
		$where[]="cat.published=1";
		$where[] = "a.access IN (".$groups.")" ;
		$where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		$orderby        = $this->_buildContentOrderBy();
                       $query = ' SELECT a.*, a.title AS booktitle, cat.title AS cattitle, '
			. " CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(':', a.id, a.alias) ELSE a.id END as slug, "
			. " CASE WHEN CHAR_LENGTH(cat.alias) THEN CONCAT_WS(':', cat.id, cat.alias) ELSE cat.id END as slugcat "
                        . ' FROM #__abbook AS a'
			. ' LEFT JOIN #__abbookauth AS aa ON aa.idbook = a.id '
			//. ' LEFT JOIN #__abauthor AS bb ON bb.id=aa.idauth '
			. ' LEFT JOIN #__abcategories AS cat ON a.catid=cat.id ' 
			. $where
			. ' GROUP BY a.id '
			. $orderby
                        ;
                return $query;
	}

	function _buildContentOrderBy()
        {
                $order=$this->config->get( 'search_display_order', "title" );
                if ($order=="title"){
                        $order="booktitle";
                }
                $order_dir=$this->config->get( 'search_display_order_dir', "ASC" );
                $orderby        = ' ORDER BY '.$order.' '.$order_dir;
                return $orderby;
        }

	function getData()
        {
error_log("limitstart ".$this->getState('limitstart')."--limit ".$this->getState('limit'));
                // Lets load the data if it doesn't already exist
                if (empty( $this->_data ))
                {
                        $query = $this->_buildQuery();
                        $this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit')  );
			$total = count($this->_data);
                        for($i = 0; $i < $total; $i++)
                        {
                                $item =& $this->_data[$i];
                                $item->authors = $this->_Authorname($item->id);
				$item->tags = $this->_Tagname($item->id);
				$this->_voting($item->id);
                        	$item->vote=$this->_voting;
                        }
                }
                return $this->_data;
        }

	protected function _Authorname($idbook)
        {
                // Lets load the content if it doesn't already exist
                $query = 'SELECT a.name AS author, a.id AS idauthor, a.alias' .
                         ' FROM #__abbookauth AS b'.
                         ' JOIN #__abauthor AS a ON a.id = b.idauth' .
                         ' WHERE b.idbook = '. (int) $idbook;
                $this->_db->setQuery($query);
                $this->_authors = $this->_db->loadObjectList();
                return $this->_authors;
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

	function getTotal()
        {
		if (empty($this->_total))
                {
                        $query = $this->_buildQuery();
                        $this->_total = $this->_getListCount($query);
                }
                return $this->_total;
        }

        function getPagination()
        {
                // Lets load the content if it doesn't already exist
                if (empty($this->_pagination))
                {
                        jimport('joomla.html.pagination');
                        $this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
                }

                return $this->_pagination;
        }


	function &getCategorieslist() {
//funziona con la tabella #__abcategories
       /*
        	if (empty( $this->_categorieslist )) {
                	$query = ' SELECT *'
                		. ' FROM #__abcategories'
				. ' WHERE published=1'
                        	;
                }
                if (empty($this->_categorieslist)) {
                        $this->_db->setQuery( $query );
                        $rows = $this->_getList( $query );
                }
                $children = array();
                        // first pass - collect children
                        foreach ($rows as $v ){
                                $pt = $v->parent_id;
                                $list = @$children[$pt] ? $children[$pt] : array();
                                array_push( $list, $v );
                                $children[$pt] = $list;
                        }
                        // second pass - get an indent list of the items
			JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
                        $this->_categorieslist = JHTML::_('menu.treerecurse', 0, '', '', array(), $children);*/
//qua provo con la tabella delle categorie di joomla
		if (empty( $this->_categorieslist )) {
			$app = JFactory::getApplication();
                        $menu = $app->getMenu();
                        $active = $menu->getActive();
                        $params = new JRegistry();

                        if($active)
                        {
                                $params->loadJSON($active->params);
                        }
			$options = array();
                        $options['countItems'] = $params->get('show_cat_num_links_cat', 1) || $params->get('show_empty_categories', 0);
			$categories = JCategories::getInstance('Tecnomed', $options);
                        $this->_categorieslist = $categories->get($this->getState('category.id', 'root'));
                        if(is_object($this->_categorieslist))
                        {
                                $this->_children = $this->_categorieslist->getChildren();
                                $this->_parent = false;
                                if($this->_categorieslist->getParent())
                                {
                                        $this->_parent = $this->_categorieslist->getParent();
                                }
                                $this->_rightsibling = $this->_categorieslist->getSibling();
                                $this->_leftsibling = $this->_categorieslist->getSibling(false);
                        } else {
                                $this->_children = false;
                                $this->_parent = false;
                        }
		}
                return $this->_categorieslist;
        }

	public function getParent()
        {
                if(!is_object($this->_item))
                {
                        $this->getCategorieslist();
                }
                return $this->_parent;
        }

        /**
         * Get the sibling (adjacent) categories.
         *
         * @return      mixed   An array of categories or false if an error occurs.
         */
        function &getLeftSibling()
        {
                if(!is_object($this->_item))
                {
                        $this->getCategorieslist();
                }
                return $this->_leftsibling;
        }

        function &getRightSibling()
        {
                if(!is_object($this->_item))
                {
                        $this->getCategorieslist();
                }
                return $this->_rightsibling;
        }
	function &getChildren()
        {
                if(!is_object($this->_item))
                {
                        $this->getCategorieslist();
                }
                return $this->_children;
        }

        function &getEditorslist() {
                if (empty( $this->_editorslist )) {
                        $query = ' SELECT * '
                        . ' FROM #__abeditor'
                        ;
                }
                if (empty($this->_editorslist)) {
                        $this->_db->setQuery( $query );
                        $this->_editorslist = $this->_getList( $query );
                }

                return $this->_editorslist;
        }

	function &getLibrarieslist() {
                if (empty( $this->_librarieslist )) {
                        $query = ' SELECT * '
                        . ' FROM #__ablibrary'
                        ;
                }
                if (empty($this->_librarieslist)) {
                        $this->_db->setQuery( $query );
                        $this->_librarieslist = $this->_getList( $query );
                }
                return $this->_librarieslist;
        }

        function &getLocationslist() {
                if (empty( $this->_locationslist )) {
                        $query = ' SELECT id, name '
                        . ' FROM #__ablocations'
                        ;
                }
                if (empty($this->_locationslist)) {
                        $this->_db->setQuery( $query );
                        $this->_locationslist = $this->_getList( $query );
                }
                return $this->_locationslist;
        }

	function &getAuthorslist() {
                if (empty( $this->_authorslist )) {
                        $query = ' SELECT * '
                        . ' FROM #__abauthor'
                        ;
                }
                if (empty($this->_authorslist)) {
                        $this->_db->setQuery( $query );
                        $this->_authorslist = $this->_getList( $query );
                }

                return $this->_authorslist;
        }

	        function &getYearlist() {
                if (empty( $this->_yearlist )) {
			$query = ' SELECT DISTINCT year as id, year as name'
                                . ' FROM #__abbook '
                                ;
                        if ($this->typesearch == 1) {
                                $cat=$this->selectedcat();
                                $query .= ' WHERE catid IN ('.$cat .')';
                        }
                        $this->_db->setQuery( $query );
                        $this->_yearlist = $this->_getList( $query );
                }

                return $this->_yearlist;
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
