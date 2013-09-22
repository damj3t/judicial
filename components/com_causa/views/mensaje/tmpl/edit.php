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

/*
	<div>
	<div class="width-60 fltlft">
		<div class="span6"> 
			<form action="http://nodesms.aws.af.cm/admin/api/damj3t@gmail.com" method="post" name="adminForm" id="item-form"> 
				<div class="controls controls-row"> 
					<input id="nombre" name="nombre" type="text" class="span3" placeholder="Tu nombre">  
					<input id="tel" name="tel" type="tel" class="span3" placeholder="Telefono destino"> 
				</div> 
				<div class="controls"> 
					<textarea id="msj" name="msj" class="span6" placeholder="Mensaje" rows="5"></textarea> 
				</div> 

				<div class="controls"> 
					<button type ="submit" id="contact-submit"  name="enviar" class="btn btn-primary input-medium pull-right">Enviar</button> 
				</div> 
				<input id="email" name="email" type="text" value= "damj3t@gmail.com" style="display:none;"> 
				<input id="pass" name="pass" type="text" value= "14201998" style="display:none;">
				 
			</form> 
		</div>       
     </div>
	  </div>

	 */ 
?>
<form action="<?php JRoute::_('index.php?option=com_causa'); ?>" method="post" name="adminForm" id="item-form">
	<div>
	 
			<div class="width-60 fltlft">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'COM_CAUSA_FIELDSET_MENSAJE' ); ?></legend>
					<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('details') as $field): ?>
									<li><?php echo $field->label;echo $field->input;?></li>
					<?php endforeach; ?>
					</ul> 
				</fieldset>
				<input type="hidden" name="option" value="com_causa" />
			    <input type="hidden" name="task" value="mensaje.submit" />
			    <button type="submit" class="button"><?php echo JText::_('Guardar'); ?></button> 
		     </div>

  </div>
 		<?php echo JHtml::_('form.token'); ?>
   
</form>
		     

<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
