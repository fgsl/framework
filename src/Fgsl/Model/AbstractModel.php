<?php
declare(strict_types = 1);
/**
 *  FGSL Framework
 *  @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 *  @copyright FGSL 2023
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
namespace Generic\Model;

abstract class AbstractModel
{
    public function __construct()
    {
        $this->exchangeArray([]);
    }    
    
    public function exchangeArray(array $data):void
    {
        $attributes = get_object_vars($this);
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = (is_int($this->$attribute) ? (int) $data[$attribute] : $data[$attribute]);
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}