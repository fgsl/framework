<?php
namespace Fgsl\Test\DoctrineManager;

use Fgsl\Db\DoctrineManager\DoctrineManager;

/**
 *  test case.  
 */
class DoctrineManagerTest extends \PHPUnit\Framework\TestCase
{    
    public function testManager()
    {        
        $this->assertNull(DoctrineManager::getEntityManager());        
    }
}

