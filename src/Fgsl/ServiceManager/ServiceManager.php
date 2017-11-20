<?php
namespace Fgsl\ServiceManager;

use Zend\ServiceManager\ServiceLocatorInterface;
class ServiceManager
{
    /**
     * @var ServiceLocatorInterface
     */
    private static $instance = null;

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @param ServiceLocatorInterface $instance
     */
    public static function setInstance(ServiceLocatorInterface $instance)
    {
        self::$instance = $instance;
    }
}