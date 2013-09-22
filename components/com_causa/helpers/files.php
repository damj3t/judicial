<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.helper');
jimport('joomla.html.html');
class JHtmlFiles
{
        public static function files( $name, $active = NULL, $javascript = NULL, $directory, $extensions =  "pdf|doc|odt|txt" )
        {
                jimport( 'joomla.filesystem.folder' );
                $listFiles = JFolder::files( JPATH_SITE.DS.$directory );
                $files         = array(  JHTML::_('select.option',  '', '- '. JText::_( 'COM_TECNOMED_SELECT_FILE' ) .' -' ) );
                foreach ( $listFiles as $file ) {
                   if ( preg_match( '#('.$extensions.')$#', $file ) ) {
                                $files[] = JHTML::_('select.option',  $file );
                        }
                }
                $files = JHTML::_('select.genericlist',  $files, $name,  array(
                                'list.attr' => 'class="inputbox" size="1" '. $javascript,
                                'list.select' => $active
                        ));

                return $files;
        }
}
