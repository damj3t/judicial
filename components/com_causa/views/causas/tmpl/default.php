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
//$canOrder       = $user->authorise('core.edit.state', 'com_causa.causas');
//$saveOrder      = $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_causa&view=causas'); ?>" method="post" name="adminForm">
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
			<th width="10%">
                        	<?php echo JText::_('JFIELD_RIT_LABEL'); ?>
            </th>
            <th width="10%">
                        	<?php echo JText::_('JFIELD_RUC_LABEL'); ?>
            </th>
            <th width="10%">
                        	<?php echo JText::_('JFIELD_FISCAL_LABEL'); ?>
            </th>
            <th width="20%">
                        	<?php echo JText::_('JFIELD_ARCHIVOS_LABEL'); ?>
            </th>
             <th width="20%">
                        	<?php echo JText::_('JFIELD_AUDIENCIAS_LABEL'); ?>
            </th>
             <th width="12%">
                        	<?php echo JText::_('JFIELD_ESTADO_LABEL'); ?>
            </th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($this->items as $i => $item) :	
		//$canCreate      = $user->authorise('core.create','com_causa.paciente.'.$item->id);
        $link 		= JRoute::_( 'index.php?option=com_causa&task=causa.edit&id='. $item->id );
       	$archivo 	= JRoute::_( 'index.php?option=com_causa&view=archivos&id_causa='. $item->id );
        $audiencias = JRoute::_( 'index.php?option=com_causa&view=audiencias&id_causa='. $item->id );
        $newaudiencias = JRoute::_( 'index.php?option=com_causa&task=audiencia.add&id_causa='. $item->id.'&tmpl=component');
        $newarchivo = JRoute::_( 'index.php?option=com_causa&task=archivo.add&id_causa='. $item->id.'&tmpl=component');
        	?>
		<tr class="row<?php echo $i % 2; ?>">
			<td class="center">
				<?php echo $item->id; ?>
			</td>
			<td>
                <a href="<?php echo $link;?>">
                <?php echo $this->escape($item->cliente); ?></a>
            </td>
            <td>
                <?php echo $this->escape($item->rit); ?>
					
           </td>
			<td>
                <?php echo $this->escape($item->ruc); ?>
					
           </td>
           <td>
                <?php echo $this->escape($item->fiscal); ?>
					
           </td>
           <td>
	           <a href="<?php echo $archivo;?>">
	           		<button class="btn btn-warning" type="button">ver</button>
	           </a>    
	           <a class="modal" rel="{handler: 'iframe', size: {x: 500, y: 500}}" href="<?php echo $newarchivo  ?>">
           			<button class="btn btn-warning" type="button">Nuevo</button>
               </a>
           </td>
           <td>
           		<a href="<?php echo $audiencias;?>">
           			<button class="btn btn-warning" type="button">Ver</button>
               </a>
               <a class="modal" rel="{handler: 'iframe', size: {x: 500, y: 500}}" href="<?php echo $newaudiencias  ?>">
           			<button class="btn btn-warning" type="button">Nueva</button>
               </a>
           </td>
            <td>
           
                <span class="label label-success"> <?php echo $this->escape($item->estado); ?></span>
            
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
