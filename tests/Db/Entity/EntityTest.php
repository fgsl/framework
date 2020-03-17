<?php
namespace Fgsl\Test\Db\Entity;

/**
 *  test case.  
 */
class EntityTest extends \PHPUnit\Framework\TestCase
{    
    public function testEntity()
    {        
        $entity = new Entity();
        $entity->exchangeArray(['id' => 1, 'name' => 'neo']);
        $this->assertEquals(1,$entity->getArrayCopy()['id']);
    }
}

