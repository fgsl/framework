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
namespace Fgsl\Db\TableGateway;

use Fgsl\Model\AbstractModel;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGatewayInterface;

abstract class AbstractTableGateway
{
    /**
     *
     * @var string
     */
    protected $keyName;

    /**
     *
     * @var string
     */
    protected $modelName;

    /**
     *
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     *
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     *
     * @param string $where
     * @return ResultSetInterface
     */
    public function getModels($where = null)
    {
        $resultSet = $this->tableGateway->select($where);
        return $resultSet;
    }

    /**
     *
     * @param mixed $key
     * @return AbstractModel
     */
    public function getModel($key)
    {
        $models = $this->getModels([
            $this->keyName => $key
        ]);
        if ($models->count() == 0 || $models->current() == null ){
            $model = $this->modelName;
            return new $model(
                $this->keyName,
                $this->tableGateway->getTable(),
                $this->tableGateway->getAdapter());
        }
        return $models->current();
    }

    /**
     *
     * @param AbstractModel $model
     */
    public function save(AbstractModel $model)
    {
        $primaryKey = $this->keyName;
        $key = $model->$primaryKey;
        $set = $model->getArrayCopy();
        $existingModel = $this->getModel($key);
        if (!isset($existingModel->$primaryKey)) {
            $this->tableGateway->insert($set);
        } else {
            $this->tableGateway->update($set, array(
                $this->keyName => $key
            ));
        }
    }

    /**
     *
     * @param mixed $key
     */
    public function delete($key)
    {
        $this->tableGateway->delete(array(
            $this->keyName => $key
        ));
    }

    /**
     * @return Sql
     */
    public function getSql()
    {
        return $this->tableGateway->getSql();
    }

    /**
     *
     * @return \Laminas\Db\Sql\Select
     */
    public function getSelect()
    {
        $select = new Select($this->tableGateway->getTable());
        return $select;
    }

    /**
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->tableGateway->getTable();
    }

}