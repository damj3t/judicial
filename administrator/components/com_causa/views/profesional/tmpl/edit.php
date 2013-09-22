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
//JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(task)
        {
                if (task == 'profesional.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
                        submitform(task);
                } else {
                        alert( "<?php echo JText::_( 'JGLOBAL_VALIDATION_FORM_FAILED' ); ?>" );
                }
        }
</script>
<form action="<?php JRoute::_('index.php?option=com_causa'); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
		<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_TECNOMED_FIELDSET_PROFESIONAL' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('details') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		</div>
	

	<div class="width-40 fltrt">
        <?php echo JHtml::_('sliders.start','tecnomed-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	
		<?php echo JHtml::_('sliders.panel',JText::_('COM_TECNOMED_IMAGE_PACIENTE'), 'profesional-details'); ?>
            <fieldset class="adminform">
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('images') as $field): ?>
					<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul>
			<?php if ($this->item->image <> '') { ?>
			<li>
				<label id="jform_preview-lbl" for="jform_preview" class="hasTip"><?php echo JText::_('JGLOBAL_PREVIEW'); ?></label>
				<?php echo JHTML::_('image',$this->item->image, JText::_('COM_TECNOMED_IMAGE'), array('align' => 'middle', 'height'=>'100px', 'width'=>'100px')); ?>
			
			</li>
			<?php }else { ?>
			<li>
				<label id="jform_preview-lbl" for="jform_preview" class="hasTip"><?php echo JText::_('JGLOBAL_PREVIEW'); ?></label>
				<?php echo JHTML::_('image','administrator/components/com_causa/assets/images/client.png', JText::_('COM_TECNOMED_IMAGE'), array('align' => 'middle', 'height'=>'100px', 'width'=>'100px')); ?>
			
			</li>
			<?php } ?>
            </fieldset>
	
		<?php echo JHtml::_('sliders.end'); ?>
	  </div>	
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
      
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
