<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/
defined('_JEXEC') or die('Restricted access');
$user   = JFactory::getUser();
//$canOrder       = $user->authorise('core.edit.state', 'com_causa.cliente');
//$saveOrder      = $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_causa&view=clientes'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div>
                        <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
                        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_CAUSA_SEARCH_IN_NAME'); ?>" />
                        <button type="submit" class="button"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                        <button type="button" class="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
       </div>
    </fieldset>
    <div class="clr"> </div>
	<table class="table table-bordered">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20%">
                                <?php echo JText::_('JFIELD_NOMBRE_LABEL');?>
			</th>
			<th width="20%">
                        	<?php echo JText::_('JFIELD_DIRECCION_LABEL'); ?>
            </th>
            <th width="10%">
                        	<?php echo JText::_('JFIELD_TELEFONO_LABEL'); ?>
            </th>
            <th width="10%">
                        	<?php echo JText::_('JFIELD_CELULAR_LABEL'); ?>
            </th>
             <th width="20%">
                        	<?php echo JText::_('JFIELD_CAUSA_LABEL'); ?>
            </th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($this->items as $i => $item) :	
		//$canCreate      = $user->authorise('core.create','com_causa.paciente.'.$item->id);
        $link 		= JRoute::_( 'index.php?option=com_causa&task=cliente.edit&id='. $item->id );
        $causa 		= JRoute::_( 'index.php?option=com_causa&view=causas&id='. $item->id );
		$newcausa 		= JRoute::_( 'index.php?option=com_causa&task=causa.add&id_client='. $item->id);
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td class="center">
				<?php echo $item->id; ?>
			</td>
			<td>
                <a href="<?php echo $link;?>">
                <?php echo $this->escape($item->nombre); ?></a>
            </td>
            <td>
                <?php echo $this->escape($item->direccion); ?>
					
           </td>
			<td>
                <?php echo $this->escape($item->telefono); ?>		
           </td>
           <td>
                <?php echo $this->escape($item->celular); ?>
					
           </td>
           <td>
                  <a href="<?php echo $causa;?>">
                  <button class="btn btn-warning" type="button">Causas</button>
                  </a>
                  <a href="<?php echo $newcausa;?>">
                  <button class="btn btn-warning" type="button">Nueva Causa</button>
                  </a>
           </td>
		</tr>
	<?php endforeach; ?>
	
	</tbody>
	</table >
	<div class="clr"></div>
	<table> 
    	<tr class= "pagination" >
    		<td><?php echo $this->pagination->getListFooter(); ?></td>
    	</tr>
    </table>
  		
  	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
   <?php echo JHtml::_('form.token'); ?>

</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
