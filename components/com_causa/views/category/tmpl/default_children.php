<?php
/**
 * @version             $Id: default_children.php 17017 2010-05-13 10:48:48Z eddieajau $
 * @package             Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license             GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = 'first';
//funzione alternativa per ordinare le categorie
//jimport( 'joomla.utilities.arrayhelper' );
//JArrayHelper::sortObjects(&$this->children[$this->category->id], "title", $direction=-1)
?>

<?php if (count($this->children[$this->category->id]) > 0) : ?>
        <ul class="bookcategories">
        <?php foreach($this->children[$this->category->id] as $id => $child) : ?>
                <?php
                if ($this->params->get('show_empty_categories', 1) || $child->getNumItems(true) || count($child->getChildren())) :
                        if (!isset($this->children[$this->category->id][$id + 1])) :
                                $class = 'last';
                        endif;
                ?>

                <li class="<?php echo $class; ?> folder">
                        <?php $class = ''; ?>
			<?php $catimage=$this->params->get('catimage')== "cat_custom_image"?$child->getParams()->get('image', '/components/com_abook/assets/images/no_img_cat.png') : "components/com_abook/assets/images/folder/".$this->params->get('catimage', "folder_blue.png"); ?>
			<img class="cat-img-folder" src="<?php echo $catimage; ?>" style="vertical-align:middle;"/>	
                        <span class="jitem-title"><a href="<?php echo JRoute::_(TecnomedHelperRoute::getCategoryRoute($child->id));?>">
                                <?php echo $this->escape($child->title); ?></a>
				<?php if ( $this->params->get('show_item_count', 0)) : ?>
					(<?php echo $child->getNumItems(true); ?>)
				<?php endif ; ?>
                        </span>

                        <?php if ($child->description && $this->params->get('show_list_description', 0) == 1) : ?>
                                <div class="category-desc">
                                        <?php echo JHtml::_('content.prepare', $child->description); ?>
                                </div>
                        <?php endif; ?>

                        <?php if (count($child->getChildren()) > 0 ) :
                                $this->children[$child->id] = $child->getChildren();
                                $this->category = $child;
                                $this->maxLevel--;
                                if ($this->maxLevel != 0) :
                                        echo $this->loadTemplate('children');
                                endif;
                                $this->category = $child->getParent();
                                $this->maxLevel++;
                        endif; ?>
                        </li>
                <?php endif; ?>
        <?php endforeach; ?>
        </ul>
<?php endif; ?>
