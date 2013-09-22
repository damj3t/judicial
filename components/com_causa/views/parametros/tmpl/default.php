<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined('_JEXEC') or die('Restricted access');
$user   = JFactory::getUser();
//$listOrder      = $this->state->get('list.ordering');
//$listDirn       = $this->state->get('list.direction');
//$canOrder       = $user->authorise('core.edit.state', 'com_causa.parametro');
//$saveOrder      = $listOrder == 'a.ordering';
$addParametro 	= JRoute::_( 'index.php?option=com_causa&task=parametro.add&layout=modal&tmpl=component');
               
?>
<form action="<?php echo JRoute::_('index.php?option=com_causa&view=parametros'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div >
		
		 <label class="filter-search-lbl" for="filter_grupo_id"><?php echo JText::_('JSEARCH_FILTER_GRUPO'); ?></label>
		<select name="filter_grupo_id" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('JOPTION_SELECT_GRUPO');?></option>
			<?php echo JHtml::_('select.options', $this->Parametros, 'value', 'text', $this->state->get('filter.grupo_id'));?>
		</select>
		
        <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('JSEARCH_IN_NAME'); ?>" />
        <button type="submit" class="button"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
        <button type="button" class="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        <a class="modal" rel="{handler: 'iframe', size: {x: 500, y: 500}}" href="<?php echo $addParametro  ?>">
           	<button class="btn btn-warning" type="button">Nuevo Parametro</button>
        </a>
       </div>
    </fieldset>
    <div class="clr"> </div>
    <div class="width-60 fltlft">        
	<table class="table table-bordered">
	<thead>
		<tr>

			<th width="5%">
                                <?php echo JText::_('JFIELD_CODIGO_LABEL');?>
			</th>
			<th width="20%">
                        	<?php echo JText::_('JFIELD_NOMBRE_LABEL'); ?>
            </th>
            <th width="20%">
                        	<?php echo JText::_('JFIELD_GRUPO_LABEL'); ?>
            </th>
		</tr>
	</thead>

	<tbody>
	<?php
	foreach ($this->items as $i => $item) :	
		$canCreate      = $user->authorise('core.create','com_causa.parametro.'.$item->id);
        $link 		= JRoute::_( 'index.php?option=com_causa&task=parametro.edit&id='. $item->id );
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td>
                <?php echo $this->escape($item->cod_item); ?>
					
           </td>
			<td>
                <a href="<?php echo $link;?>">
                <?php echo $this->escape($item->desc_item); ?></a>
           </td>
            <td>
                <?php echo $this->escape($item->grupo); ?>
					
           </td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<div class="clr"></div>
	<div>
	<table> 
    	<tr class= "pagination" >
    		<td><?php echo $this->pagination->getListFooter(); ?></td>
    	</tr>
    </table>
    </div>
    </div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
   <?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
