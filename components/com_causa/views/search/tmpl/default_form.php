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
defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JRoute::_( 'index.php?option=com_abook&view=search' ); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<div class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
                	<div valign="top" align="left" class="key abook_search_params">
				<p>
                   			<label for="title"><?php echo JText::_( 'COM_ABOOK_TITLE' ); ?>:</label>
                                	<input type="text" name="keyword" id="keyword" size="10" maxlength="10" value="<?php echo $this->lists['keyword']; ?>" />
                        	</p>
                             	<p>
					<label for="category"><?php echo JText::_( 'COM_ABOOK_CATEGORY' ); ?>:</label>
                                	<?php echo $this->lists['category']; ?>
                        	</p>
                                <p>
					<label for="location"><?php echo JText::_( 'COM_ABOOK_LOCATION' ); ?>:</label>
					<?php echo $this->lists['location']; ?>
				</p>
                               	<p>
					<label for="ideditor"><?php echo JText::_( 'COM_ABOOK_EDITOR' ); ?>:</label>
                                	<?php echo $this->lists['ideditor']; ?>
                        	</p>
                                <p>
					<label for="author"><?php echo JText::_( 'COM_ABOOK_AUTHOR' ); ?>:</label>
					<?php echo $this->lists['author']; ?>
				</p>
				<p>
                 	       		<label for="year"><?php echo JText::_( 'COM_ABOOK_YEAR' ); ?>:</label>
                               		<input class="text_area" type="year" name="year" id="title" size="4" maxlength="4" value="<?php echo $this->lists['year'];?>" />
                        	</p>
				<p>
                        		<label for="library"><?php echo JText::_( 'COM_ABOOK_LIBRARY' ); ?>:</label>
					<?php echo $this->lists['library']; ?>
                        	</p>
			</div>
			<div class="clr"></div>
			<div class="search-button">
                                <button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_( 'COM_ABOOK_SEARCH' );?></button>
			</div>
	</div>

	<input type="hidden" name="option" value="com_abook" />
	<input type="hidden" name="task" value="search.search" />
	<input type="hidden" name="controller" value="search" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
