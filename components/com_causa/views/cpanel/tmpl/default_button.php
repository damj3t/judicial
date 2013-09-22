<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
*/
defined('_JEXEC') or die;
?>
<div id="cpanel">
<?php //foreach ($this->buttons as $button){ 
for ($i=0, $n=count( $this->buttons ); $i < $n; $i++)
{
	$button = &$this->buttons[$i];
	?>
<div class="icon-wrapper">
        <div class="icon">
                <a href="<?php echo $button->link; ?>">
                        <?php echo JHTML::_('image', 'components/com_causa/assets/images/'.$button->imagen, ""); ?>
                        <span><?php echo JText::_( $button->texto); ?></span></a>
        </div>
</div>
<?php } ?>
</div>