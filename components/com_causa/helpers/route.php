<?php

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

abstract class CausaHelperRoute
{
	protected static $lookup;
	/**
	 * @param	int	The route of the newsfeed
	 */
	public static function getBookRoute($id, $catid)
	{
		$needles = array(
			'book'  => array((int) $id)
		);
		//Create the link
		$link = 'index.php?option=com_abook&view=book&id='. $id;
		if ($catid > 1)
		{
			$categories = JCategories::getInstance('Causa');
			$category = $categories->get($catid);
			if ($category) {
				$needles['category'] = array_reverse($category->getPath());
				$needles['categories'] = $needles['category'];
				$link .= '&catid='.$catid;
			}
		}
		if ($item = self::_findItem($needles)) {
                        $link .= '&Itemid='.$item;
                }
                elseif ($item = self::_findItem()) {
                        $link .= '&Itemid='.$item;
                }

		return $link;
	}

	public static function getCategoryRoute($catid)
	{
		if ($catid instanceof JCategoryNode){
                        $id = $catid->id;
                        $category = $catid;
                }else{
                        $id = (int) $catid;
                        $category = JCategories::getInstance('Causa')->get($id);
                }

                if($id < 1){
			$needles = array(
                                'categories' => array($id)
                        );
			if ($item = self::_findItem($needles)) {
                                $link = 'index.php?Itemid='.$item;
                        } else {
                        	$link = 'index.php?option=com_abook&view=categories&id=0';
			}
                }else{
                        $needles = array(
                                'category' => array($id)
                        );
                        if ($item = self::_findItem($needles)) {
                                $link = 'index.php?Itemid='.$item;
                        } else {
                              //Create the link
                                $link = 'index.php?option=com_abook&view=category&id='.$id;
                                if($category){
                                        $catids = array_reverse($category->getPath());
                                        $needles = array(
                                                'category' => $catids,
                                                'categories' => $catids
                                        );
                                        if ($item = self::_findItem($needles)) {
                                                $link .= '&Itemid='.$item;
                                        }
                                        elseif ($item = self::_findItem()) {
                                                $link .= '&Itemid='.$item;
                                        }
                                }
                        }
                }
                return $link;
	}

        public static function getAuthorRoute($id)
        {
                $needles = array(
                        'author'  => array((int) $id)
                );
                //Create the link
                $link = 'index.php?option=com_abook&view=author&id='. $id;

                if ($item = self::_findItem($needles)) {
                        $link .= '&Itemid='.$item;
                }
		elseif ($item = self::_findItem()) {
                	$link .= '&Itemid='.$item;
                }

                return $link;
        }

	public static function getTagRoute($id)
        {
                $needles = array(
                        'tag' => array((int) $id)
                );
                //Create the link
                $link = 'index.php?option=com_abook&view=tag&id='.$id;

                if ($item = self::_findItem($needles)) {
                        $link .= '&Itemid='.$item;
                }
		elseif ($item = self::_findItem()) {
                        $link .= '&Itemid='.$item;
                }

                return $link;
        }

	protected static function _findItem($needles=null)
	{
//error_log(print_r($needles, true), 3, 'debug.log');
		$app    = JFactory::getApplication();
                $menus  = $app->getMenu('site');
                // Prepare the reverse lookup array.
                if (self::$lookup === null){
                        self::$lookup = array();
                        $component      = JComponentHelper::getComponent('com_abook');
                        $items          = $menus->getItems('component_id', $component->id);
                        foreach ($items as $item){
                                if (isset($item->query) && isset($item->query['view'])){
                                        $view = $item->query['view'];
                                        if (!isset(self::$lookup[$view])) {
                                                self::$lookup[$view] = array();
                                        }
                                        if (isset($item->query['id'])) {
                                                self::$lookup[$view][$item->query['id']] = $item->id;
                                        }
                                }
                        }
                }

                if ($needles){
                        foreach ($needles as $view => $ids){
                                if (isset(self::$lookup[$view])){
                                        foreach($ids as $id){
                                                if (isset(self::$lookup[$view][(int)$id])) {
                                                        return self::$lookup[$view][(int)$id];
                                                }
                                        }
                                }
                        }
                } else {
                        $active = $menus->getActive();
                        if ($active && $active->component == 'com_abook') {
                                return $active->id;
                        }
                }

                return null;
	}
}
