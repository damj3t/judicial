<?php
// no direct access
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');
$pageClass = $this->params->get('pageclass_sfx');
?>
<div class="contact-category<?php echo $pageClass;?>">
	<?php if ($this->params->def('show_page_heading', 1)) : ?>
	<h1>
		<?php echo $this->params->get( 'page_heading', $this->params->def('comp_name'));?>	
	</h1>
	<?php endif; ?>
        <?php if ($this->params->get( 'search', 1 )== 1) { ?>
                <?php echo JHTML::_('icon.search');?>
                <div class="clr"></div>
        <?php } ?>
        <?php if ($this->params->get( 'breadcrumb', 2 )== 2) { ?>
                <div class="abook-path">
                        <?php echo JHTML::_('icon.breadcrumb', $this->path);?>
                </div>
        <div class="clr"></div>
        <?php } ?>
<?php if($this->params->get('show_category_title', 1)) : ?>
<h2>
	<?php echo $this->category->title; ?>
</h2>
<?php endif; ?>
<?php if ($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="abook_category_desc">
	<?php if ($this->params->get('show_description_image', 1) && $this->category->getParams()->get('image')) : ?>
		<img src="<?php echo $this->category->getParams()->get('image'); ?>" class="cat-image"/>
	<?php endif; ?>
	<?php if ($this->params->get('show_description') && $this->category->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->category->description); ?>
	<?php endif; ?>
	<div class="clr"></div>
	</div>
<?php endif; ?>

<?php if (!empty($this->children[$this->category->id])) : ?>
<div class="cat-children">
        <h3><?php echo JText::_('COM_ABOOK_SUBCATEGORIES') ; ?></h3>
        <?php echo $this->loadTemplate('children'); ?>
</div>
<?php endif; ?>

<?php echo $this->loadTemplate('items'); ?>

</div>
