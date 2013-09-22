<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class CausaModelArchivos extends JModelList
{
        public function __construct($config = array())
        {
                if (empty($config['filter_fields'])) {
                        $config['filter_fields'] = array(
                                'id', 'a.id',
                                'state', 'a.state'
                               
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

              //  $language = $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
              //  $this->setState('filter.language', $language);

		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('u.nombre', 'asc');
        }

	protected function getStoreId($id = '')
        {
                // Compile the store id.
                $id.= ':' . $this->getState('filter.search');
			//	$id.= ':' . $this->getState('filter.language');

                return parent::getStoreId($id);
        }

	protected function getListQuery()
        {
                // Create a new query object.
                $db             = $this->getDbo();
                $query  = $db->getQuery(true);
                $user	 =& JFactory::getUser();	
		
				$id_causa = JRequest::getVar('id_causa');
                // Select the required fields from the table.
                $query->select(
                        $this->getState(
                                'list.select',
                                'a.*'
                        )
                );
                $query->from('`#__sico_documentos` AS a');
         	// Join over the users for the checked out user.
                $query->select('b.ruc AS rut');
                $query->select('b.rit AS rit');
                $query->select('b.ruc AS ruc');
				$query->join('LEFT', '#__sico_causas AS b ON b.id=a.id_causa');

			// Join over the users for the checked out user.
                $query->select('u.nombre AS cliente');
                $query->join('LEFT', '#__sico_clientes AS u ON u.id=b.id_cliente');
        		
                if ($id_causa > 0){
                $query->where('a.id_causa ='.$id_causa );
				}
				
				 $query->where('a.id_user ='.$user->id );

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
