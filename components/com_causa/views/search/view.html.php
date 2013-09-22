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

jimport( 'joomla.application.component.view' );
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');

class TecnomedViewSearch extends JView
{
        function display($tpl = null)
        {
                // Get data from the model
		$error  = '';
		$searchkey	= $this->get( 'key');
		$total      = $this->get( 'total');
		if ($searchkey > 0) {
			$items          = & $this->get( 'data');
			if (count($items) > 0) {
				$pagination = & $this->get( 'pagination' );
			}else{
				$error=JText::_( 'COM_ABOOK_NO_RESULT' );
			}
		}
		$app    = JFactory::getApplication();
		//prendo i parametri globali di abook e faccio un merge con i parametri del menu
		$params = $app->getParams();
		$menus  = $app->getMenu();
                $menu   = $menus->getActive();
		$menu_params = new JRegistry;
                $menu_params->loadString($menu->params);
		$params->merge($menu_params);
		//fine merge parametri


		$pathway   =& $app->getPathway();
		$document       =& JFactory::getDocument();
		$document->addStyleSheet(DS.'components'.DS.'com_abook'.DS.'assets'.DS.'css'.DS.'style.css');
		$categorieslist          =JHtml::_('category.options', 'com_abook', array('filter.published' => array(1,1)) );
		if ($params->get('show_search_editor', 1)) {
			$editorslist          =& $this->get('Editorslist');
		}
                if ($params->get('show_search_auth', 1)) {
			$authorslist          =& $this->get('Authorslist');
		}
                if ($params->get('show_search_loc', 1)) {
	                $locationslist          =& $this->get('Locationslist');
		}
                if ($params->get('show_search_lib', 1)) {
		$librarieslist          =& $this->get('Librarieslist');
		}
                if ($params->get('show_search_year', 1)) {
                        $yearlist          =& $this->get('Yearlist');
                }
		
		$lists['keyword'] = isset($searchkey['keyword'])? $searchkey['keyword']:'';
		$lists['year'] = isset($searchkey['year'])?$searchkey['year']:'';

                $top[]    = JHTML::_('select.option', NULL , JText::_('COM_ABOOK_SELECT_A_CATEGORY'), 'value', 'text');
                $categorieslist=array_merge($top, $categorieslist);
		$lists['category'] = JHTML::_('select.genericlist', $categorieslist, 'category', 'class="inputbox" size="1"','value', 'text', isset($searchkey['category'])?$searchkey['category']:"");

		$topeditor[]    = JHTML::_('select.option', NULL , JText::_('COM_ABOOK_SELECT_AN_EDITOR'), 'id', 'name');
                $editorslist=array_merge($topeditor, $editorslist);
                $lists['ideditor'] = JHTML::_('select.genericlist', $editorslist, 'ideditor', 'class="inputbox" size="1"','id', 'name', isset($searchkey['ideditor'])?$searchkey['ideditor']:"");

		$topauthor[]    = JHTML::_('select.option', NULL , JText::_('COM_ABOOK_SELECT_AN_AUTHOR'), 'id', 'name');
		$authorslist=array_merge($topauthor, $authorslist);

		$lists['author'] = JHTML::_('select.genericlist', $authorslist, 'author', 'class="inputbox" size="1"','id', 'name', isset($searchkey['author'])?$searchkey['author']:"");

		$toplocation[]    = JHTML::_('select.option', NULL , JText::_('COM_ABOOK_SELECT_A_LOCATION'), 'id', 'name');
                $locationslist=array_merge($toplocation, $locationslist);

                $lists['location'] = JHTML::_('select.genericlist', $locationslist, 'location', 'class="inputbox" size="1"','id', 'name', isset($searchkey['location'])?$searchkey['location']:"");

		$toplibraries[]    = JHTML::_('select.option', NULL, JText::_('COM_ABOOK_SELECT_A_LIBRARY'), 'id', 'name');
                $librarieslist=array_merge($toplibraries, $librarieslist);
                $lists['library'] = JHTML::_('select.genericlist', $librarieslist, 'library', 'class="inputbox" size="1"','id', 'name', isset($searchkey['library'])?$searchkey['library']:"");

		$lists['n_items']=JText::_( 'COM_ABOOK_TOTALRESULTSFOUND').' '. $total;

		$params = $app->getParams();

		JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');

		//*-------------
		$menus  = $app->getMenu();
                $menu   = $menus->getActive();
		if ($menu){
                        $params->def('page_heading', $params->get('page_title', $menu->title));
                }else{
                        $params->def('page_heading', $params->def('comp_name'));
                }
//------------*/


                // push data into the template
                $this->assignRef('lists', $lists);
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('searchkey', $searchkey);
		$this->assignRef('params', $params);
		$this->assign('error', $error);
	
		$pathway->addItem(JText::_('COM_ABOOK_SEARCH'), '');	
                parent::display($tpl);
        }
}
