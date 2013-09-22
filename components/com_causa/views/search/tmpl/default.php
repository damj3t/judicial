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

<?php if ( $this->params->get( 'show_page_title', 1 ) ) : ?>
<div class="item-page<?php echo $pageClass;?>">
        <?php if ($this->params->def('show_page_heading', 1)) : ?>
                <h1><?php echo $this->params->get( 'page_heading', $this->params->def('comp_name'));?></h1>
        <?php endif; ?>
</div>
<?php endif; ?>
<?php echo $this->loadTemplate('form'); ?>
<?php if(!$this->error && count($this->searchkey) > 0) :
        echo $this->loadTemplate('results');
else :
        echo $this->loadTemplate('error');
endif; 
?>

