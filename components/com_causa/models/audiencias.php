<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class CausaModelAudiencias extends JModelList
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

		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('a.nombre', 'asc');
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
                $db     = $this->getDbo();
                $query  = $db->getQuery(true);
               
				$id_causa = JRequest::getVar('id_causa');
                // Select the required fields from the table.
                $query->select(
                        $this->getState(
                                'list.select',
                                'a.*'
                        )
                );
                $query->from('`#__sico_audiencias` AS a');
				
				if ($id > 0){
                $query->where('a.id_causa ='.$id_causa );
				}
                // Join over the users for the checked out user.
				$query->select('d.rit AS rit');
                $query->select('d.ruc AS ruc');
				$query->join('LEFT', '#__sico_causas AS d ON d.id=a.id_causa');

                $query->select('e.nombre AS cliente');
                $query->join('LEFT', '#__sico_clientes AS e ON e.id=d.id_cliente');

                  
			

		// Filter by search in title
                $search = $this->getState('filter.search');
                if (!empty($search)) {
                        if (stripos($search, 'id:') === 0) {
                                $query->where('a.id = '.(int) substr($search, 3));
                        } else {
                                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                                $query->where('(d.ruc LIKE '.$search.')');
                        }
                }
     
                return $query;
        }
}	
