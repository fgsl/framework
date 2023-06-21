<?php
declare(strict_types = 1);
/**
 *  FGSL Framework
 *  @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 *  @copyright FGSL 2020
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
namespace Fgsl\Db\DoctrineManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\DriverManager;
use Fgsl\ServiceManager\ServiceManager;

final class DoctrineManager
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): ?EntityManager
    {
        return self::$entityManager;
    }

    public static function initialize(string $doctrinePath, string $modulePath, string $moduleName)
    {
        $conn = self::getDoctrineConfig();
        $config = new Configuration();
        $cache = new ArrayCache();
        $config->setMetadataCache($cache);
        $annotationPath	= $doctrinePath . '/ORM/Mapping/Driver/DoctrineAnnotations.php';
        AnnotationRegistry::registerFile($annotationPath);
        $driver = new AnnotationDriver(
            new AnnotationReader(),
            array("$modulePath/src/$moduleName/Model")
        );
        $config->setMetadataDriverImpl($driver);
        $config->setProxyDir("$modulePath/src/$moduleName/Proxy");
        $config->setProxyNamespace("$moduleName\\Proxy");
        self::$entityManager = DriverManager::getConnection($conn, $config);
    }

    /**
     *
     * @return array
     */
    private static function getDoctrineConfig() {
        $config = ServiceManager::getInstance()->get('Config');
        return $config['doctrine_config'];
    }
}