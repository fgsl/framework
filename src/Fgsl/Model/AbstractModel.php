<?php
namespace Fgsl\Model;

use Zend\Db\RowGateway\RowGateway;

abstract class AbstractModel extends RowGateway
{
    /**
     *
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     *
     * @return \Zend\InputFilter\InputFilterInterface
     */
    abstract public function getInputFilter();

    /**
     *
     * @return array
     */
    public function getArrayCopy()
    {
        $attributes = get_object_vars($this);
        unset($attributes['inputFilter']);
        return $attributes;
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