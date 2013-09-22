<?php
/**
 * @version		$Id: categories.php
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.model');
jimport('joomla.application.categories');
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers/categories.php');

class TecnomedModelCategories extends JModel
{
	public $_context = 'com_abook.categories';

	protected $_extension = 'com_abook';

	private $_parent = null;

	private $_items = null;

	protected function populateState()
	{
		$app = JFactory::getApplication();
		$this->setState('filter.extension', $this->_extension);

		// Get the parent id if defined.
		$parentId = JRequest::getInt('id');
		$this->setState('filter.parentId', $parentId);

		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('filter.published',	1);
		$this->setState('filter.access',	true);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.extension');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.parentId');

		return parent::getStoreId($id);
	}

	public function getItems()
	{
		if(!count($this->_items))
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
			$this->_parent = $categories->get($this->getState('filter.parentId', 'root'));
			if(is_object($this->_parent))
			{
				$this->_items = $this->_parent->getChildren();
			} else {
				$this->_items = false;
			}
		}

		return $this->_items;
	}

	public function getParent()
	{
		if(!is_object($this->_parent)){
			$this->getItems();
		}
		return $this->_parent;
	}
//ho messo questa funzione per cercare di sovrascrivere quella originale e aggiungere l'ordinamento ma non funziona. 14/08/2011
	/*function &getChildren()
        {
                if(!is_object($this->_items)){
                        $this->getCategory();
                }
                // Order subcategories
                if (sizeof($this->_children)) {
                        $params = $this->getState()->get('params');
                        if ($params->get('cat_display_order') == 'title' || $params->get('cat_display_order') == 'rtitle') {
                                jimport('joomla.utilities.arrayhelper');
                                JArrayHelper::sortObjects($this->_children, $params->get('cat_display_order'), ($params->get('cat_display_order') == 'title') ? 1 : -1);
                        }
                }
                return $this->_children;
        }*/
}
