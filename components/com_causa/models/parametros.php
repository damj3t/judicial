<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 * @license GNU/GPL, see LICENSE.php
 * Causa is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Causa is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Causa; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class CausaModelParametros
 extends JModelList
{
        public function __construct($config = array())
        {
                if (empty($config['filter_fields'])) {
                        $config['filter_fields'] = array(
                                'id', 'a.id',
                                'published', 'a.published',
                                 'ordering', 'a.ordering'
                               
                        );
                }
                parent::__construct($config);
        }
	protected function populateState()
        {
		// Initialise variables.
                $app = JFactory::getApplication('administrator');

                $search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
                $this->setState('filter.search', $search);

               $parametro = $this->getUserStateFromRequest($this->context.'.filter.grupo_id', 'filter_grupo_id');
		       $this->setState('filter.grupo_id', $parametro);
           
		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('a.nombre', 'asc');
        }

	protected function getStoreId($id = '')
        {
                // Compile the store id.
                $id.= ':' . $this->getState('filter.search');
 				$id	.= ':'.$this->getState('filter.grupo_id');
                return parent::getStoreId($id);
        }

	protected function getListQuery()
        {
                // Create a new query object.
                $db             = $this->getDbo();
                $query  = $db->getQuery(true);

                // Select the required fields from the table.
                $query->select(
                        $this->getState(
                                'list.select',
                                'a.*'
                        )
                );
                $query->from('`#__sico_paramet` AS a');
	
			
		// Join over the users for the checked out user.
                $query->select("(select e.desc_item from #__sico_paramet e where e.cod_grupo = a.cod_grupo and e.cod_item =0) as grupo");

				$query->where ('a.cod_item > 0');
         // Filter by author
				$parametro = $this->getState('filter.grupo_id');
				if (is_numeric($parametro)) {
					$query->where("a.cod_grupo = ".(int) $parametro);
				}else{
					$query->where("a.cod_grupo = 0");
				
				}
				
				$query->order ('cod_grupo ASC ');
				$query->order ('a.cod_item ASC ');
				
		// Filter by search in title
                $search = $this->getState('filter.search');
                if (!empty($search)) {
                        if (stripos($search, 'id:') === 0) {
                                $query->where('a.id = '.(int) substr($search, 3));
                        } else {
                                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                                $query->where('(a.nombre LIKE '.$search.')');
                        }
                }
     
                return $query;
        }
        
public function getParametros() {
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Construct the query
		$query->select('u.cod_grupo as value , u.desc_item as text');
		$query->from('#__sico_paramet AS u');
		$query->where('cod_item =0');
		$query->order('u.desc_item');

		// Setup the query
		$db->setQuery($query->__toString());

		// Return the result
		return $db->loadObjectList();
	}
}	
?>