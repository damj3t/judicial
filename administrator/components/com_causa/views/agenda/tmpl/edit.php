<?php
//----------------------------------------------------------------------
// Sophia
// Sophia by Alex Olave - http://www.alfazeta.cl
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Author: 	Alex Olave - http://www.alfazeta.cl
// Copyright: copyright (C) 2012 - Alex Olave.
// License: 	GNU/GPL, http://www.gnu.org/copyleft/gpl.html
// Pack: 	Sophia
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Sophia is free software. This version may have been modified pursuant
// to the GNU General Public License, and as distributed it includes or
// is derivative of works licensed under the GNU General Public License or
// other free or open source software licenses.
//----------------------------------------------------------------------

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script language="javascript" type="text/javascript">
	function submitbutton(task)
        {
                if (task == 'agenda.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
			<?php foreach($this->form->getFieldset('profesional') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		</div>
		<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_TECNOMED_FIELDSET_DIAS' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('dias') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		</div>
		<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_TECNOMED_FIELDSET_FECHAS' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('fecha_agenda') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		</div>
		<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_TECNOMED_FIELDSET_FRANJA_HORARIA' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('horas') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
		</div>

		<input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
      
</form>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>

