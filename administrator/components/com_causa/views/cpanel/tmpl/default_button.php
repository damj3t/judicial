<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 * @license GNU/GPL, see LICENSE.php
 * Causa is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * Causa is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Causa; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
defined('_JEXEC') or die;
?>
<?php foreach ($this->buttons as $button){ ?>
<div class="icon-wrapper">
        <div class="icon">
                <a href="<?php echo $button['link']; ?>">
                        <?php echo JHTML::_('image', 'administrator/components/com_causa/assets/images/'.$button['image'], ""); ?>
                        <span><?php echo $button['text']; ?></span></a>
        </div>
</div>
<?php } ?>
