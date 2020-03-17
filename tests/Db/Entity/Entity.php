<?php
namespace Fgsl\Test\Db\Entity;

use Fgsl\Db\Entity\AbstractEntity;

class Entity extends AbstractEntity
{
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function getKeyValue()
    {
        return key(get_object_vars($this));
    }
    
    public function getInputFilter()
    {
        return null;
    }
}