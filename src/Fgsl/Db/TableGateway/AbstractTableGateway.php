<?php
namespace Fgsl\Db\TableGateway;

use Fgsl\Model\AbstractModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Sql;

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
        if ($models->count() == 0){
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
        if (! $this->getModel($key)->$primaryKey) {
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
     * @return \Zend\Db\Sql\Select
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