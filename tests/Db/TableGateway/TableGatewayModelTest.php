<?php
declare(strict_types=1);
namespace Fgsl\Test\Db\TableGateway;

use Laminas\Db\TableGateway\TableGateway as LaminasTableGateway;
use PHPUnit\Framework\TestCase;

/**
 *  test case.  
 */
class TableGatewayModelTest extends TestCase
{    
    /**
     * @covers LaminasTableGateway
     */
    public function testTableGatewayModel()
    {        
        $ltg = $this->createMock(LaminasTableGateway::class);
        $tg = new TableGatewayModel($ltg);
        $this->assertNotNull($tg->getKeyName());
    }
}

