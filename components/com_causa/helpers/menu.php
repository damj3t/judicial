<?php
/**
 * @package Joomla
 * @subpackage Causa
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class JHTMLMenu
{
	function treerecurse( $id, $indent, $img, $list, &$children, $maxlevel=9999, $level=0, $type=1 )
        {
                if (@$children[$id] && $level <= $maxlevel)
                {
                        foreach ($children[$id] as $v)
                        {
                                $id = $v->id;

                                if ( $type ) {
                                        $pre    = '<sup>|_</sup>&nbsp;';
                                        $spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                } else {
                                        $pre    = '- ';
                                        $spacer = '&nbsp;&nbsp;';
                                }

                                if ( $v->parent_id == 0 ) {
                                        $txt    = $img . $v->name;
                                } else {
                                        $txt    = $pre . $img . $v->name;
                                }
                                $pt = $v->parent_id;
                                $list[$id] = $v;
                                $list[$id]->treename = "$indent$txt";
                                $list[$id]->children = count( @$children[$id] );
				$list = JHTMLMenu::treerecurse($id, $indent . $spacer, $img, $list, $children, $maxlevel, $level+1, $type);
                        }
                }
                return $list;
        }
}
