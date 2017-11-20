<?php
namespace Fgsl\Db\Entity;

use Zend\InputFilter\InputFilterInterface;

abstract class AbstractEntity
{
    /**
     *
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @return InputFilterInterface
     */
    abstract public function getInputFilter();

    /**
     * @param array $array
     */
    public function exchangeArray($array)
    {
        foreach ($array as $attribute => $value) {
            $this->$attribute = $value;
        }
    }

    /**
     * @return array
     */
    abstract public function getArrayCopy();
    /**
     * @return mixed
     */
    abstract public function getKeyValue();
}