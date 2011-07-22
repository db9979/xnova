<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-2010, Grégory PLANCHAT <g.planchat at gmail.com>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

require_once 'Nova/ModelAbstract.php';
/**
 * Base object collection management class
 *
 * @access      public
 * @author      gplanchat
 * @category    Dal
 * @package     Nova
 * @subpackage  Nova_Dal
 */
abstract class Nova_CollectionAbstract
    extends Nova_ModelAbstract
{
    protected $_children = array();

    public function offsetExists($offset)
    {
        if (is_int($offset)) {
            return $this->_offsetExists($offset);
        }
        return parent::offsetExists($offset);
    }

    protected function _offsetExists($offset)
    {
        return array_key_exists($offset, $this->_children);
    }

    public function offsetGet($offset)
    {
        if (is_int($offset)) {
            return $this->_offsetGet($offset);
        }
        return parent::offsetGet($offset);
    }

    public function _offsetGet($offset)
    {
        if ($this->_offsetExists($offset)) {
            return $this->_children[$offset];
        }
        return NULL;
    }

    public function offsetSet($offset, $value)
    {
        if (is_int($offset)) {
            return $this->_offsetSet($offset, $value);
        }
        return parent::offsetSet($offset, $value);
    }

    public function _offsetSet($offset, $value)
    {
        $this->_children[$offset] = $value;

        return $value;
    }

    public function offsetUnset($offset)
    {
        if (is_int($offset)) {
            return $this->_offsetUnset($offset);
        }
        return parent::offsetUnset($offset);
    }

    public function _offsetUnset($offset)
    {
        if ($this->_offsetExists($offset)) {
            unset($this->_children[$offset]);
        }
    }
}
