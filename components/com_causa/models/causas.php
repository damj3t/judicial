<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class CausaModelCausas extends JModelList
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

              //  $language = $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
              //  $this->setState('filter.language', $language);

		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('a.nombre', 'asc');
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
                $db     = $this->getDbo();
                $user	 =& JFactory::getUser();
                $query  = $db->getQuery(true);
				$id = JRequest::getVar('id');
                // Select the required fields from the table.
                $query->select(
                        $this->getState(
                                'list.select',
                                'a.*'
                        )
                );
                $query->from('`#__sico_causas` AS a');
				if ($id > 0){
                $query->where('a.id_cliente ='.$id );
				}
				 $query->where('a.id_user ='. $user->id );
                // Join over the users for the checked out user.
                $query->select('u.nombre AS cliente');
                $query->join('LEFT', '#__sico_clientes AS u ON u.id=a.id_cliente');

                // Join over the users for the checked out user.
                $query->select('b.nombre AS fiscal');
                $query->join('LEFT', '#__sico_abogados AS b ON b.id=a.id_fiscal and b.id_tipo=2');
               
                // Join over the users for the checked out user.
                $query->select('c.nombre AS fiscal');
                $query->join('LEFT', '#__sico_abogados AS c ON c.id=a.id_fiscal_adj and c.id_tipo=3');

                 // Join over the users for the checked out user.
                $query->select('d.desc_item AS estado');
                $query->join('LEFT', '#__sico_paramet AS d ON d.cod_item=a.state and d.cod_grupo =3 and d.cod_item>0');
              
			

		// Filter by search in title
                $search = $this->getState('filter.search');
                if (!empty($search)) {
                        if (stripos($search, 'id:') === 0) {
                                $query->where('a.id = '.(int) substr($search, 3));
                        } else {
                                $search = $db->Quote('%'.$db->getEscaped($search, true).'%');
                                $query->where('(a.ruc LIKE '.$search.')');
                        }
                }
     
                return $query;
        }
}	
