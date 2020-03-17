<?php
namespace Fgsl\Test\Authentication\Adapter;
use Fgsl\Authentication\Adapter\DoctrineTable;
use Doctrine\ORM\EntityManager;
use Laminas\Authentication\Result;
use Doctrine\ORM\Query;
use Doctrine\ORM\Configuration;

/**
 *  test case.  
 */
class DoctrineTableTest extends \PHPUnit\Framework\TestCase
{    
    public function testAdapter()
    {
        $this->expectException(\Doctrine\ORM\Query\QueryException::class);
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->method('getConfiguration')->willReturn(new Configuration());
        $entityManager->method('createQuery')->willReturn(new Query($entityManager));        
        $adapter = new DoctrineTable($entityManager);
        $adapter->setEntityName('users');
        $adapter->setIdentity('identity');
        $adapter->setCredential('credential');
        $adapter->authenticate();
    }
}

