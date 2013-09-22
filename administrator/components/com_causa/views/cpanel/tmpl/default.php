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
defined('_JEXEC') or die('Restricted access');
?>
<div class="width-60 fltlft">

		<div id="cpanel">
		<?php
			echo $this->loadTemplate('button');
		?>
        </div>

</div>
<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','tecnomed-sliders-info'); ?>

        <?php echo JHtml::_('sliders.panel',JText::_('COM_TECNOMED_FIELDSET_INFO'), 'publishing-details'); ?>
        <fieldset class="panelform">
		<table class="adminlist">
			<tbody>
                  <tr>
                      <td>
                          <p><?php echo JText::_( 'COM_TECNOMED_DONATE' ); ?></p>
                      </td>
                  </tr>
			</tbody>
        	</table>
	</fieldset>

        <?php echo JHtml::_('sliders.end'); ?>
</div>
<div class="clr"></div>
<p><?php echo JHTML::_('credit.credit');?></p>
