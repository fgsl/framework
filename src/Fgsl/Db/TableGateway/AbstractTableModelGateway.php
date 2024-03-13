<?php
declare(strict_types=1);
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
namespace Fgsl\Db\TableGateway;

use Fgsl\Model\AbstractModel;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGatewayInterface;

abstract class AbstractTableModelGateway
{
    protected string $keyName;

    protected string $modelName;

    protected TableGatewayInterface $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getModels($where = null, $order = null): ResultSetInterface
    {
        if (is_null($order)){
            $resultSet = $this->tableGateway->select($where);
        } else {
            $select = $this->getSelect();
            $select->order($order);
            if (!is_null($where)) $select->where($where);
            $resultSet = $this->tableGateway->selectWith($select);
        }
        
        return $resultSet;
    }

    /**
     *
     * @param mixed $key
     */
    public function getModel($key): AbstractModel
    {
        $models = $this->getModels([
            $this->keyName => $key
        ]);
        if ($models->count() == 0 || $models->current() == null ){
            $model = $this->modelName;
            return new $model();
        }
        return $models->current();
    }

    /**
     * @return int
     */
    public function save(AbstractModel $model, $excludePrimaryKey = false)
    {
        $primaryKey = $this->keyName;
        $key = $model->$primaryKey;
        $set = $model->getArrayCopy();
        $existingModel = $this->getModel($key);
        if ($excludePrimaryKey){
            unset($set[$primaryKey]);
        }
        if (!isset($existingModel->$primaryKey)) {
            return $this->tableGateway->insert($set);
        } else {
            return $this->tableGateway->update($set, array(
                $this->keyName => $key
            ));
        }
    }

    /**
     *
     * @param mixed $key
     * @return int
     */
    public function delete($key)
    {
        return $this->tableGateway->delete(array(
            $this->keyName => $key
        ));
    }

    public function getSql(): Sql
    {
        return $this->tableGateway->getSql();
    }

    public function getSelect(): Select
    {
        $select = new Select($this->tableGateway->getTable());
        return $select;
    }

    public function getKeyName(): string
    {
        return $this->keyName;
    }

    public function getTable(): string
    {
        return $this->tableGateway->getTable();
    }

    public function getByField(string $field, $value): AbstractModel
    {
        $where = [
            $field => $value
        ];
        $rowSet = $this->getModels($where);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }
    
    public function getByFields(array $fields): AbstractModel
    {
        $where = [];
        foreach($fields as $field => $value){
            $where[$field] = $value;
        }
        $rowSet = $this->getModels($where);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }    
}