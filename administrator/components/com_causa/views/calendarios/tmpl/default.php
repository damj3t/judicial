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
defined('_JEXEC') or die('Restricted access');
$user   = JFactory::getUser();
JHTML::_('behavior.calendar');
//$listOrder      = $this->state->get('list.ordering');
//$listDirn       = $this->state->get('list.direction');
$canOrder       = $user->authorise('core.edit.state', 'com_causa.calendario');
$saveOrder      = $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_causa&view=calendarios'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
                        <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
                        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_TECNOMED_SEARCH_IN_NAME'); ?>" />
                        <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                        <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				        <label for="filter_from" id="filter_from_label"><?php echo JText::_('From'); ?>: </label>
				        <input class="inputbox" size="12" name="fecha"	id="fecha" value="<?php echo $this->state->get('filter.search'); ?>" />
						<input type="reset" class="button" value="..."	onclick="return showCalendar('fecha','%Y-%m-%d');" />
				
       </div>
    </fieldset>
        <div class="clr"> </div>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="2%">
				<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />	
			</th>			
			<th width="20%">
                                <?php echo JText::_('JFIELD_NOMBRE_PROFESIONAL');?>
			</th>
			<th width="10%">
                        	<?php echo JText::_('JFIELD_FECHA'); ?>
            </th>
            <th width="10%">
                        	<?php echo JText::_('JFIELD_HORA'); ?>
            </th>
			<th width="10%">
                        	<?php echo JText::_('JFIELD_PACIENTE'); ?>
            </th>
		</tr>
	</thead>
	<tfoot>
    		<tr>
      			<td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
    		</tr>
  	</tfoot>
	<tbody>
	<?php
	foreach ($this->items as $i => $item) :	
		$canCreate      = $user->authorise('core.create', 'com_causa.calendario.'.$item->id);
        $link 		= JRoute::_( 'index.php?option=com_causa&task=calendario.edit&id='. $item->id );
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td class="center">
				<?php echo $item->id; ?>
			</td>
			<td>
				<?php echo JHtml::_('grid.id', $i, $item->id); ?>
			</td>
			<td>
                <a href="<?php echo $link;?>">
                <?php echo $this->escape($item->profesional); ?></a>
                <p class="smallsub">
                      <?php echo JText::sprintf('JGLOBAL_LIST_ESPECIALIDAD', $this->escape($item->profesional));?>
				</p>
            </td>
            <td>
                <?php echo $this->escape($item->fecha); ?>				
           </td>
			<td>
                <?php echo $this->escape($item->hora); ?>				
           </td>
		   <td>
                <?php echo $this->escape($item->paciente); ?>
           </td>
		  
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
   <?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
