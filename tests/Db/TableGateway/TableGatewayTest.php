<?php
declare(strict_types=1);
namespace Fgsl\Test\Db\TableGateway;

use Laminas\Db\TableGateway\TableGateway as LaminasTableGateway;
use PHPUnit\Framework\TestCase;

/**
 *  test case.  
 */
class TableGatewayTest extends TestCase
{    
    /**
     * @covers LaminasTableGateway
     */
    public function testTableGateway()
    {        
        $ltg = $this->createMock(LaminasTableGateway::class);
        $tg = new TableGateway($ltg);        
        $this->assertNotNull($tg->getKeyName());
    }
}

