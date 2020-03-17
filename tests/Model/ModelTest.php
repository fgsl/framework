<?php
namespace Fgsl\Test\Model;

use Fgsl\Mock\Db\Adapter\Mock;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testModel() 
    {
        $adapter = new Mock();    

        $person = new Person('code','person',$adapter);
        $person->exchangeArray([
            'code' => 42,
            'name' => 'Answer'       
        ]);
        
        $this->assertIsArray($person->getArrayCopy());        
        $this->assertIsInt($person->getArrayCopy()['code']);
        $this->assertCount(2, $person->getArrayCopy());
    }
}