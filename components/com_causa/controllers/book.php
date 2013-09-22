<?
/**
 * @package Joomla
 * @subpackage Tecnomed
 * @copyright (C) 2010 Ugolotti Federica
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
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

jimport('joomla.application.component.controllerform');

class TecnomedControllerBook extends JControllerForm
{
	
        function vote(){
		// Check for request forgeries.
                JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

                $user_rating = JRequest::getInt('user_rating', -1);

                if ( $user_rating > -1 ) {
                        $url = JRequest::getString('url', '');
                        $id = JRequest::getInt('id', 0);
                        $viewName = JRequest::getString('view', $this->default_view);
			$model = $this->getModel($viewName);

                        if ($model->storeVote($id, $user_rating)) {
                                $this->setRedirect($url, JText::_('COM_ABOOK_BOOK_VOTE_SUCCESS'));
                        } else {
                                $this->setRedirect($url, JText::_('COM_ABOOK_BOOK_VOTE_FAILURE'));
                        }
                }
        }
}
