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

class CausaModelCpanel extends JModelList
{
	public function getBotones() {

	
			$db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('bot.*');
			$query->from( '#__sico_botones AS bot');
			$query->where('bot.menu = 3');
			$query->where('bot.published = 1');
			$query->order('bot.id');

			$this->_db->setQuery($query);
			$this->admin = $this->_db->loadObjectList();
		

		return $this->admin;
	}

	public function getAudiencias() {

        if (empty($this->audiencias)) {

            $user	 =& JFactory::getUser();
		    $db = $this->getDbo();
			$query = $db->getQuery(true);
			$query->select('DATE_FORMAT(au.fecha_audiencia,"%e") as diaactual ');
			$query->select('au.fecha_audiencia as fecha ');
			$query->select('au.motivo as motivo ');
			
			$query->from( '#__sico_audiencias AS au');
			$query->where('au.state = 1');
			$query->order('au.fecha_audiencia ASC');
			
			//echo $query;
			$this->_db->setQuery($query);
            $this->audiencias = $this->_db->loadObjectList();
        }

        return $this->audiencias;
    }
    
	function getAudienciasPendientes()
        {
                // Lets load the data if it doesn't already exist
                if (empty( $this->_AudienciasPendientes ))
                {
                        $query = "SELECT a.id,DATE_FORMAT(a.fecha_audiencia,'%d-%m-%Y') as fecha_audiencia,a.hora "
                        . ', c.desc_item as sala,d.desc_item as edificio ,e.nombre as cliente, a.id_causa'
                        . "\n FROM #__sico_audiencias AS a"
                        . ' LEFT JOIN #__sico_causas AS b ON a.id_causa = b.id'
                        . ' LEFT JOIN #__sico_clientes AS e ON b.id_cliente = e.id'
                        . ' LEFT JOIN #__sico_paramet AS c ON a.sala = c.cod_item and c.cod_grupo= 12 '
                        . ' LEFT JOIN #__sico_paramet AS d ON a.edificio = d.cod_item and c.cod_grupo = 13'
                        . ' ORDER BY a.fecha_audiencia,a.hora DESC'
                        ;
                        $this->_AudienciasPendientes = $this->_getList( $query, 0, 10 );
                }
                return $this->_AudienciasPendientes;
        }
        
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

		// Load the parameters.
                $params = JComponentHelper::getParams('com_causa');
                $this->setState('params', $params);

                parent::populateState('a.fecha_audiencia,a.hora', 'asc');
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
               
				$id = JRequest::getVar('id');
                // Select the required fields from the table.
                $query->select(
                        $this->getState(
                                'list.select',
                                "a.id,DATE_FORMAT(a.fecha_audiencia,'%d-%m-%Y') as fecha_audiencia,a.hora"
                        )
                );
                $query->from('`#__sico_audiencias` AS a');
				
				if ($id > 0){
                $query->where('a.id_causa ='.$id );
				}
                // Join over the users for the checked out user.
				
                $query->select(' e.nombre as cliente');
                 $query->join('LEFT', '#__sico_causas AS b ON a.id_causa = b.id');
                 $query->join('LEFT', ' #__sico_clientes AS e ON b.id_cliente = e.id');
                 	
				
                
				$query->select(' c.desc_item as sala');
				$query->join('LEFT', '#__sico_paramet AS c ON a.sala = c.cod_item and c.cod_grupo= 12 ');

				$query->select(' d.desc_item as edificio');
                 $query->join('LEFT', '#__sico_paramet AS d ON a.edificio = d.cod_item and c.cod_grupo = 13');
                 


     
                return $query;
        }

}	
