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

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class TecnomedControllerSearch extends JController
{
	function display($cachable = false, $urlparams = false)
	{
		JRequest::setVar('view','search');
		return parent::display($cachable, $urlparams);
	}

	function search()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// slashes cause errors, <> get stripped anyway later on. # causes problems.
		$post   = JRequest::get('post');
//error_log(print_r($post, true), 3, '/tmp/debug.log');
		$badchars = array('#','>','<','\\'); 
		$post['keyword'] = trim(str_replace($badchars, '', JRequest::getString('keyword', null, 'post')));
		foreach ($post as $key=>$value){
			if($post[$key] == ''){
				unset($post[$key]);
			}
		}
		$keyword          = $post['keyword']=='' ? '' : '&keyword=' .$post['keyword'];
		$category          = $post['category']=='' ? '' : '&category=' .$post['category'];
		$location          = $post['location']=='' ? '' : '&location=' .$post['location'];
		$author          = $post['author']=='' ? '' : '&author=' .$post['author'];
		$ideditor          = $post['ideditor']=='' ? '' : '&ideditor=' .$post['ideditor'];
		$author          = $post['author']=='' ? '' : '&author=' .$post['author'];
		$year          = $post['year']=='' ? '' : '&year=' .$post['year'];
		$library          = $post['library']=='' ? '' : '&library=' .$post['library'];
		unset($post['task']);
                unset($post['submit']);

		$uri = JURI::getInstance();
                $uri->setQuery($post);
		$uri->setVar('view', 'search');

                $this->setRedirect(JRoute::_('index.php?&option=com_abook&view=search'.$keyword.$category.$location.$author.$ideditor.$author.$year.$library, false));
	}
}
