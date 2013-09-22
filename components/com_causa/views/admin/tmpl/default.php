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

	
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
