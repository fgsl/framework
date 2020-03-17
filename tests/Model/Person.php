<?php
namespace Fgsl\Test\Model;

use Fgsl\Model\AbstractModel;

class Person extends AbstractModel
{    
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
