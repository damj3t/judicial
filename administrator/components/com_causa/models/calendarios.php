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

class CausaModelCalendarios extends JModelList
{
        public function __construct($config = array())
        {
                if (empty($config['filter_fields'])) {
                        $config['filter_fields'] = array(
                                'id', 'a.id',
                                'published', 'a.published',
                                 'ordering', 'a.ordering',
								 'nombre','u.nombre'
                               
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

		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('u.nombre', 'asc');
        }

	protected function getStoreId($id = '')
        {
                // Compile the store id.
                $id.= ':' . $this->getState('filter.search');

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
                $query->from('`#__tm_agenda_det` AS a');
		// Join over the users for the checked out user.
                $query->select('u.nombre AS profesional');
                $query->join('LEFT', '#__tm_profesionales AS u ON u.id=a.profesional_id');
				
				 $query->select('p.nombre AS paciente');
                $query->join('LEFT', '#__tm_pacientes AS p ON p.id=a.paciente_id');


		// Filter by search in title
                $search = $this->getState('filter.search');
                if (!empty($search)) {
                        if (stripos($search, 'id:') === 0) {
                                $query->where('a.id = '.(int) substr($search, 3));
                        } else {
                                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                                $query->where('(u.nombre LIKE '.$search.')');
                        }
                }
     
                return $query;
        }
}	
