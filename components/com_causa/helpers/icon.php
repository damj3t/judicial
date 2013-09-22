<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2013 Alex Olave
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
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

class JHTMLIcon
{

	function pdf($book, $params, $access, $attribs = array())
        {
               	$url  = 'index.php?view=book&option=com_abook';
		$url .=  @$book->catid ? '&catid='.$book->catid : '';
		$url .= '&id='.$book->id.'&format=pdf';
               	$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                // checks template image directory for image, if non found default are loaded
       	        if ($params->get('show_icons')) {
               	        $text = JHTML::_('image.site', 'pdf_button.png', '/images/M_images/', NULL, NULL, JText::_('PDF'));
                } else {
       	                $text = JText::_('PDF').'&nbsp;';
                }
       	        $attribs['title']       = JText::_( 'PDF' );
               	$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
                $attribs['rel']     = 'nofollow';
       	        return JHTML::_('link', JRoute::_($url), $text, $attribs);
       }

	function print_popup($book, $params, $access, $attribs = array())
        {
                $url  = 'index.php?view=book';
		$url .=  @$book->catid ? '&catid='.$book->catid : '';
		$url .= '&id='.$book->id.'&tmpl=component&print=1&layout=default&page='.@ $request->limitstart;

                $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

                // checks template image directory for image, if non found default are loaded
                if ( $params->get( 'show_icons' ) ) {
                        $text = JHTML::_('image.site',  'printButton.png', '/images/M_images/', NULL, NULL, JText::_( 'Print' ) );
                } else {
                        $text = JText::_( 'ICON_SEP' ) .'&nbsp;'. JText::_( 'Print' ) .'&nbsp;'. JText::_( 'ICON_SEP' );
                }

                $attribs['title']       = JText::_( 'Print' );
                $attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
                $attribs['rel']     = 'nofollow';

                return JHTML::_('link', JRoute::_($url), $text, $attribs);
        }

	function print_screen($book, $params, $access, $attribs = array())
        {
                // checks template image directory for image, if non found default are loaded
                if ( $params->get( 'show_icons' ) ) {
                        $text = JHTML::_('image.site',  'printButton.png', '/images/M_images/', NULL, NULL, JText::_( 'Print' ) );
                } else {
                        $text = JText::_( 'ICON_SEP' ) .'&nbsp;'. JText::_( 'Print' ) .'&nbsp;'. JText::_( 'ICON_SEP' );
                }
                return '<a href="#" onclick="window.print();return false;">'.$text.'</a>';
        }

	function search(){
	?>
		<form action="<?php echo JRoute::_( 'index.php?option=com_abook&view=search' ); ?>" method="post" id="searchForm" name="searchForm">
                <?php echo JHTML::_( 'form.token' ); ?>
                <div class="field-search">
                        <div>
				<input type="text" name="keyword" id="keyword" size="10" maxlength="50" value="" />
                        	<input type="hidden" name="task" value="search.search" />
                        	<input type="image" name="Search" value="<?php echo JText::_( 'COM_ABOOK_SEARCH' );?>" onclick="this.form.submit()" class="button" src="/components/com_abook/assets/images/find.png" />
			</div>
                        <div>
                        	<?php $searchlink = JRoute::_( 'index.php?option=com_abook&view=search');?>
                        	<a href="<?php echo $searchlink; ?>"><?php echo JText::_('COM_ABOOK_ADVANCED_SEARCH'); ?></a>
                        </div>
                </div>
		</form>
	<?php
	}
	
	function breadcrumb($category_parent){
	?>
		<a href="<?php echo JRoute::_(CausaHelperRoute::getCategoryRoute(0));?>"><?php echo JText::_('COM_ABOOK_BACK_TO_TOP'); ?></a> <?php echo '>';?>
        	<?php
	        $n=count($category_parent);
		if ($n>=1){
	        	foreach ($category_parent as $k => $catname){
        	        	echo '<a href="' .$catname['link'].'">' .$catname['title'] .'</a>';
	                	if ($k!=$n-1) echo ' > ';
        		}
		}
        	?>
	<?php
	}

	function votebook($book, $vote)
        {
                $html = '';
                $rating = $vote['rating'];
                $rating_count = $vote['rating_count'];

                $view = JRequest::getString('view', '');
                $img = '';

                // look for images in template if available
                $starImageOn = JHTML::_('image','system/rating_star.png', NULL, NULL, true);
                $starImageOff = JHTML::_('image','system/rating_star_blank.png', NULL, NULL, true);

                for ($i=0; $i < $rating; $i++) {
                	$img .= $starImageOn;
                }
                for ($i=$rating; $i < 5; $i++) {
                	$img .= $starImageOff;
                }
                $html .= '<span class="content_rating">';
                $html .= JText::_( 'COM_ABOOK_VOTE_USER_RATING' ) .':'. $img .'&#160;/&#160;';
                $html .= $rating_count;
                $html .= "</span>\n<br />\n";

                if ( $view == 'book' && $book->published == 1){
                	$uri = &JFactory::getURI();
                        $uri->setQuery($uri->getQuery().'&hitcount=0');

			$html .= '<form method="post" action="' . $uri->toString() . '">';
                        $html .= '<span class="content_vote">';
                        $html .= JText::_( 'COM_ABOOK_VOTE_POOR' );
                        $html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
                        $html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
                        $html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
                        $html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
                        $html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
                        $html .= JText::_( 'COM_ABOOK_VOTE_BEST' );
                        $html .= '&#160;<input class="button" type="submit" name="submit_vote" value="'. JText::_( 'COM_ABOOK_VOTE_RATE' ) .'" />';
                        $html .= '<input type="hidden" name="task" value="book.vote" />';
                        $html .= '<input type="hidden" name="hitcount" value="0" />';
                        $html .= '<input type="hidden" name="url" value="'.  $uri->toString() .'" />';
			$html .= JHtml::_('form.token');
                        $html .= '</span>';
                        $html .= '</form>';
		}
                return $html;
	}
}
