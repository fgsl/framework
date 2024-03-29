<?php
declare(strict_types=1);
/**
 *  FGSL Framework
 *  @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 *  @copyright FGSL 2020
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
namespace Fgsl\Db\Entity;

use Laminas\InputFilter\InputFilterInterface;

abstract class AbstractEntity
{
    protected ?InputFilterInterface $inputFilter = null;

    abstract public function getInputFilter(): InputFilterInterface;

    public function exchangeArray(array $array) 
    {
        foreach ($array as $attribute => $value) {
            $this->$attribute = $value;
        }
    }

    abstract public function getArrayCopy(): array;
    
    /**
     * @return mixed
     */
    abstract public function getKeyValue();
}