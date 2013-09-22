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
                if (task == 'audiencia.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
                        submitform(task);
                } else {
                        alert( "<?php echo JText::_( 'JGLOBAL_VALIDATION_FORM_FAILED' ); ?>" );
                }
        }
</script>
<form action="<?php JRoute::_('index.php?option=com_causa'); ?>" method="post" name="adminForm" id="item-form" class="form-validate" >
	<div>
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_AUDIENCIA' ); ?></legend>
			<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('details') as $field): ?>
							<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
			</ul> 
		 </fieldset>
   		   <input type="hidden" name="option" value="com_causa" />
	       <input type="hidden" name="task" value="audiencia.save" />
	       <button type="submit" class="button"><?php echo JText::_('Guardar'); ?></button>   
     </div>


	  </div>

		<?php echo JHtml::_('form.token'); ?>
 
	  
</form>
<div class="clr"></div>