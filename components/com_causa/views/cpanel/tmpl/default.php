<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 

 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
?>
<script type="text/javascript">
    window.onload = function()
    {
 		$(document).ready(function(){
 	        $('.Mytooltip').tooltip();
        });             
    }
</script>
	<div class="width-60 fltlft">
	<div>
		<?php
			echo $this->loadTemplate('button');
		?>
	</div>
	</div>
	<div class="width-40 fltlft">
	<div id="cpanel">
	<table>
		<tbody>
			<tr>
				<td width="80%">
					<?php echo $this->CalendarioAudiencias;?>
				</td>
			</tr>
		</tbody>	
	</table>
	<div class="clr"></div>
	</div>
</div>
	<div class="width-60 fltlft">
       <form action="<?php echo JRoute::_('index.php?option=com_causa&view=cpanel'); ?>" method="post" name="adminForm">
    <div class="clr"> </div>
	<table class="table table-bordered">
                        <thead>
                        	<tr>
                             	<th><?php echo JText::_( 'COM_CAUSA_FECHA' ); ?></th>
                                <th><?php echo JText::_( 'COM_CAUSA_HORA' ); ?></th>
                                <th><?php echo JText::_( 'COM_CAUSA_EDIFICIO' ); ?></th>
                                <th><?php echo JText::_( 'COM_CAUSA_SALA' ); ?></th>
                                <th><?php echo JText::_( 'COM_CAUSA_CLIENTE' ); ?></th>
                            </tr>
                        </thead>
	<tbody>
	<?php
	foreach ($this->items as $i => $item) :	
		//$canCreate      = $user->authorise('core.create','com_causa.paciente.'.$item->id);
        $link 		= JRoute::_( 'index.php?option=com_causa&task=audiencia.edit&id='. $item->id .'&tmpl=component');
       	$archivo 	= JRoute::_( 'index.php?option=com_causa&view=archivos&id_causa='. $item->id );
        $audiencias = JRoute::_( 'index.php?option=com_causa&view=archivos&id_causa='. $item->id );
        
       	?>
		  <tr class="row<?php echo $k % 2; ?>">
                                	<td width="5%" align="center">
                                        	<a class="modal" rel="{handler: 'iframe', size: {x: 500, y: 500}}" href="<?php echo $link  ?>">
                                        		<?php echo $item->fecha_audiencia; ?>
                                        	</a>
                                     </td>
                                     <td width="1%" align="center">
                                       	<?php echo $item->hora; ?>
                                     </td>
                                     <td width="1%" align="center">
                                       	<?php echo $item->edificio; ?>
                                     </td>
                                     <td width="1%" align="left">
                                       	<?php echo $item->sala; ?>
                                     </td>
                                     <td width="10%" align="left">
                                       	<?php echo $item->cliente; ?>
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
       </div> 
 

		
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
