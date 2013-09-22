<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(task)
        {
                if (task == 'cliente.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
                        submitform(task);
                } else {
                        alert( "<?php echo JText::_( 'JGLOBAL_VALIDATION_FORM_FAILED' ); ?>" );
                }
        }
</script>
<form action="<?php JRoute::_('index.php?option=com_causa'); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div>
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_CLIENTE' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('details') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		
		   <input type="hidden" name="option" value="com_causa" />
	       <input type="hidden" name="task" value="cliente.save" />
	       <button type="submit" class="button"><?php echo JText::_('Guardar'); ?></button>         
     </div>

	<div class="width-40 fltrt">
        <?php //echo JHtml::_('sliders.start','tecnomed-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	
		<?php //echo JHtml::_('sliders.panel',JText::_('COM_TECNOMED_IMAGE_PACIENTE'), 'paciente-details'); ?>
            <fieldset class="adminform">
            <legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_CLIENTE' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('images') as $field): ?>
					<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul>
			<?php if ($this->item->image <> '') { ?>
			<li>
				<label id="jform_preview-lbl" for="jform_preview" class="hasTip"><?php echo JText::_('JGLOBAL_PREVIEW'); ?></label>
				<?php echo JHTML::_('image',$this->item->image, JText::_('JFIEL_IMAGE_LABEL'), array('align' => 'middle', 'height'=>'100px', 'width'=>'100px')); ?>
			
			</li>
			<?php }else { ?>
			<li>
				<label id="jform_preview-lbl" for="jform_preview" class="hasTip"><?php echo JText::_('JGLOBAL_PREVIEW'); ?></label>
				<?php echo JHTML::_('image','administrator/components/com_causa/assets/images/client.png', JText::_('JFIEL_IMAGE_LABEL'), array('align' => 'middle', 'height'=>'100px', 'width'=>'100px')); ?>
			
			</li>
			<?php } ?>
            </fieldset>
	
		<?php //echo JHtml::_('sliders.end'); ?>
	  </div>
	  </div>

		<?php echo JHtml::_('form.token'); ?>
 
	  
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
