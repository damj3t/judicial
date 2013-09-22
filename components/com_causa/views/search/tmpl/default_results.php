<?php
/**
 * @package Joomla
 * @subpackage Tecnomed
 * @copyright (C) 2010 Ugolotti Federica
 * @license GNU/GPL, see LICENSE.php
 * Tecnomed is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Tecnomed is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Tecnomed; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined('_JEXEC') or die('Restricted access'); ?>
<div class="result">
	<hr class="separator"><?php echo $this->lists['n_items']; ?><hr class="separator">
</div>
<table class="books<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<tbody>
	<?php
        foreach($this->items as $i => $item) :
		$link = JRoute::_(TecnomedHelperRoute::getBookRoute($item->slug, $item->slugcat));
		$link2 = JRoute::_(TecnomedHelperRoute::getCategoryRoute($item->slugcat));
		?>
		<tr class="<?php echo ($i % 2) ? "odd" : "even"; ?>">
			<td width="80" height="100">
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
                                        	$link=JRoute::_(TecnomedHelperRoute::getAuthorRoute($author->idauthor.":".$author->alias));
                                                echo '<a href="'.$link.'">'.$author->author.'</a>';
                                                if ($k!=$n-1) echo ', ';
                                        } ?>
                                        </div><br />
                                <?php } ?>
				<div><?php echo JText::_('COM_ABOOK_CATEGORY') .': <a href='.$link2.'>' .$item->cattitle."</a>";?></div>
                                <?php $n=count($item->tags);
                                if ($n > 0 && $this->params->get('show_tags_search', 1)){ ?>
                                	<div><?php echo JText::_('COM_ABOOK_TAGS') .": ";
                                        foreach($item->tags as $k=>$tag) {
                                             	$link=JRoute::_(TecnomedHelperRoute::getTagRoute($tag->idtag.":".$tag->alias));
                                                echo '<a href="'.$link.'">'.$tag->tag.'</a>';
                                                if ($k!=$n-1) echo ', ';
                                        } ?>
                                        </div>
                                <?php } ?>
				<div><?php echo JText::_('COM_ABOOK_HITS') .": "; ?>
                                        <?php echo $item->hits; ?>
                                </div>
				<?php if ($this->params->get( 'view_rate', 1 )==1) { ?>
                                	<?php echo JHTML::_('icon.votebook', $item, $item->vote);?>
                                <?php } ?>
                	</td>
		</tr>
		<?php
		$k = 1 - $k;
		$i= 1 + $i;
	endforeach; ?>
	</tbody>
</table>
<div style="float:right;"><?php echo JHTML::_('credit.credit') ?></div>
        <div class="clr"></div>
<?php if ($this->params->get('bookpagination')) : ?>
                                        <div class="pagination">
                                        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                                                <p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
                                        <?php endif; ?>
                                        <?php echo $this->pagination->getPagesLinks(); ?>
                                        <p class="pagnum"><?php echo $this->pagination->getResultsCounter();?></p>
                                        </div>
                                <?php endif; ?>
