<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin');

class CausaControllerAbogados extends JControllerAdmin
{
        public function &getModel($name = 'Abogado', $prefix = 'CausaModel')
        {
                $model = parent::getModel($name, $prefix, array('ignore_request' => true));
                return $model;
        }
}
