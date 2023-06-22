<?php
declare(strict_types=1);
namespace Fgsl\Test\Db\TableGateway;

use Fgsl\Db\TableGateway\AbstractTableModelGateway;

class TableGatewayModel extends AbstractTableModelGateway
{
    protected string $keyName = 'key';
}