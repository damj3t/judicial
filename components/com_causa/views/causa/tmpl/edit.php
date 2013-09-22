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
                if (task == 'causa.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
                        submitform(task);
                } else {
                        alert( "<?php echo JText::_( 'JGLOBAL_VALIDATION_FORM_FAILED' ); ?>" );
                }
        }
</script>
<form action="<?php JRoute::_('index.php?option=com_causa'); ?>" method="post" name="adminForm" id="item-form" class="form-validate" enctype="multipart/form-data">
	<div>
			<div class="width-60 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_MATERIA' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('materia') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 
				</fieldset>
		     </div>
			 
			<div class="width-60 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_CAUSA' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('details') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 
				</fieldset>
			</div>
		     <div class="width-40 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_PREPARATORIA' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('preparatoria') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 
				</fieldset>
			</div>
		     <div class="width-40 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_JUICIO' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('juicio') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 
				</fieldset>
				</div>
		       <div class="width-60 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_TERMINO' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('termino') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 

				</fieldset>
				<input type="hidden" name="option" value="com_causa" />
			    <input type="hidden" name="task" value="causa.save" />
			    <button type="submit" class="button"><?php echo JText::_('Guardar'); ?></button> 
		     
		     </div>
		 
      </div>
<?php echo JHtml::_('form.token'); ?>
   
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
