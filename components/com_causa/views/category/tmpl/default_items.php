<?php

// no direct access
defined('_JEXEC') or die;

JHtml::core();

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_ABOOK_NO_BOOKS'); ?>	 </p>
<?php else : ?>

<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" name="adminForm">
	<table class="books">
		<tbody>
			<?php foreach($this->items as $i => $item) : ?>
				<? $link=JRoute::_(TecnomedHelperRoute::getBookRoute($item->slug, $item->slugcat));?>
				<tr class="<?php echo ($i % 2) ? "odd" : "even"; ?>">
					<td width="80" height="112">
                        			<?php if ($item->image){ ?>
                                			<a href="<? echo $link; ?>" title="<? echo JText::_('COM_ABOOK_COVEROF').' '.$item->title; ?>"><img src="<?php echo $item->image ?>" width="80" hspace="5" vspace="5" alt="<? echo JText::_('COM_ABOOK_COVEROF').' '.$item->title ;?>"/></a>
                              			<?php }else{ ?>
                                			<a href="<? echo $link; ?>" title="<? echo JText::_('COM_ABOOK_NOCOVEROF').' '.$item->title; ?>"><img src="components/com_abook/assets/images/nocover.png" width="80" alt="<? echo JText::_('COM_ABOOK_NOCOVEROF').' '.$item->title; ?>" class="nocover" /></a>
                              			<?php }?>
                        		</td>
					<td class="item-title">
						<div class="book-title">
							<a href="<?php echo $link; ?>"><?php echo $item->title; ?>
								<?php if ($item->subtitle){?>
                                        				<div class="book-subtitle"><?php echo $item->subtitle; ?></div>
                                				<?php }?>
							</a>
						</div>
						<?php $n=count($item->authors);
						if ($n > 0){ ?>
							<div><?php echo $item->editedby==1 ? JText::_('COM_ABOOK_EDITED_BY')." " : JText::_('COM_ABOOK_BY')." ";
                                                        foreach($item->authors as $k=>$author) {
                                                                $link=JRoute::_(TecnomedHelperRoute::getAuthorRoute($author->slugauthor));
                                                                echo '<a href="'.$link.'">'.$author->author.'</a>';
                                                                if ($k!=$n-1) echo ', '; ?>

                                                	<?php } ?>
							</div><br />
						<?php } ?>
						<?php $n=count($item->tags);
						if ($n > 0 && $this->params->get( 'show_cat_tags', 1 )==1){ ?>
							<div><?php echo JText::_('COM_ABOOK_TAGS') .": ";
                                                        foreach($item->tags as $k=>$tag) {
                                                                $link=JRoute::_(TecnomedHelperRoute::getTagRoute($tag->slugtag));
                                                                echo '<a href="'.$link.'">'.$tag->tag.'</a>';
                                                                if ($k!=$n-1) echo ', ';
                                                	} ?>
							</div>
						<?php }	?>
						<div><?php echo JText::_('COM_ABOOK_HITS') .": "; ?>
                                                        <?php echo $item->hits; ?>
                                                </div>
						<?php if ($this->params->get( 'view_rate',1 )==1) { ?>
                                                        <?php echo JHTML::_('icon.votebook', $item, $item->vote);?>
                                                <?php } ?>
					</td>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
	<div style="float:right;"><?php echo JHTML::_('credit.credit') ?></div>
	<div class="clr"></div>
	<?php if ($this->params->get('bookpagination')) : ?>
        	<div class="pagination">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                	<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
                        <?php endif; ?>
                        <?php echo $this->pagination->getPagesLinks();?>
                        <p class="pagnum"><?php echo $this->pagination->getResultsCounter();?></p>
                </div>
        <?php endif; ?>
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>
<?php endif; ?>
