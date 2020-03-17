<?php
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
namespace Fgsl\Model;

use Laminas\Db\RowGateway\RowGateway;
use Laminas\InputFilter\InputFilterInterface;

abstract class AbstractModel extends RowGateway
{
    /**
     *
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     *
     * @return \Laminas\InputFilter\InputFilterInterface
     */
    abstract public function getInputFilter();

    /**
     *
     * @return array
     */
    public function getArrayCopy()
    {        
        return $this->data;
    }

    public function populate(array $rowData, $rowExistsInDatabase = false)
    {
        if (isset($rowData['submit'])) unset($rowData['submit']);
        $select = $this->sql->select()->where([
            $this->primaryKeyColumn[0] =>
            $rowData[$this->primaryKeyColumn[0]]]);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $rowExistsInDatabase = ($result->count() > 0);
        parent::populate($rowData, $rowExistsInDatabase);
    }
}