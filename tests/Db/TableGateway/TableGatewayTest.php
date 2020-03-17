<?php
namespace Fgsl\Test\Db\TableGateway;

use Laminas\Db\TableGateway\TableGateway as LaminasTableGateway;

/**
 *  test case.  
 */
class TableGatewayTest extends \PHPUnit\Framework\TestCase
{    
    public function testTableGateway()
    {        
        $ltg = $this->createMock(LaminasTableGateway::class);
        $tg = new TableGateway($ltg);        
        $this->assertNotNull($tg->getKeyName());
    }
}

