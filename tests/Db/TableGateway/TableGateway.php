<?php
declare(strict_types=1);
namespace Fgsl\Test\Db\TableGateway;

use Fgsl\Db\TableGateway\AbstractTableGateway;

class TableGateway extends AbstractTableGateway
{
    protected string $keyName = 'key';
}