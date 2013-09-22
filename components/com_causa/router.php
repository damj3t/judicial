<?php

defined('_JEXEC') or die;

jimport('joomla.application.categories');
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');
/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	1.5
 */
function CausaBuildRoute(&$query)
{
	$segments	= array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_causa');
	$advanced	= $params->get('sef_advanced_link', 0);

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
		$menuItemGiven = false;
	}
	else {
		$menuItem = $menu->getItem($query['Itemid']);
		$menuItemGiven = true;
	}

	if (isset($query['view'])) {
		$view = $query['view'];
	}
	else {
		// we need to have a view in the query or it is an invalid URL
		return $segments;
	}

	// are we dealing with an article or category that is attached to a menu item?
	if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view'] && isset($query['id']) && $menuItem->query['id'] == intval($query['id'])) {
		unset($query['view']);

		if (isset($query['catid'])) {
			unset($query['catid']);
		}

		unset($query['id']);

		return $segments;
	}


//---------------------------------


	// if the layout is specified and it is the same as the layout in the menu item, we
	// unset it so it doesn't go into the query string.
	if (isset($query['layout'])) {
		if ($menuItemGiven && isset($menuItem->query['layout'])) {
			if ($query['layout'] == $menuItem->query['layout']) {

				unset($query['layout']);
			}
		}
		else {
			if ($query['layout'] == 'default') {
				unset($query['layout']);
			}
		}
	}

	return $segments;
}



/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	1.5
 */
function CausaParseRoute($segments)
{
//error_log(print_r($segments, true), 3, '/tmp/debug.log');
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	$params = JComponentHelper::getParams('com_causa');
	$advanced = $params->get('sef_advanced_link', 0);
	$db = JFactory::getDBO();

	// Count route segments
	$count = count($segments);

	// Standard routing for articles.  If we don't pick up an Itemid then we get the view from the segments
	// the first segment is the view and the last segment is the id of the article or category.
	if (!isset($item)) {
		$vars['view']	= $segments[0];
		$vars['id']		= $segments[$count - 1];

		return $vars;
	}


	// we get the category id from the menu item and search from there
	$id = $item->query['id'];
	$category = JCategories::getInstance('Causa')->get($id);

	if (!$category) {
		JError::raiseError(404, JText::_('COM_CONTENT_ERROR_PARENT_CATEGORY_NOT_FOUND'));
		return $vars;
	}

	$categories = $category->getChildren();
	$vars['catid'] = $id;
	$vars['id'] = $id;
	$found = 0;


	return $vars;
}
