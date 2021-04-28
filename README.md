# Fgsl framework

Extensions of Laminas

These components make easy to build web application using Laminas framework.

## Authentication

* Fgsl\Authentication\Adapter\DoctrineTable

This class is an database adapter that uses a Doctrine EntityManager to establish the connection.

## Db


* Fgsl\Db\DoctrineManager\DoctrineManager
* Fgsl\Entity\AbstractEntity

These two components allows to integrante Doctrine as ORM manager of application

* Fgsl\TableGateway\AbstractTableGateway

This component is an improvement for Laminas default TableGateway.

## Form

* Fgsl\Form\AbstractForm

This component allow to define dynamic forms with less code than Laminas default Form.

## InputFilter

* Fgsl\InputFilter\InputFilter

This component improves Laminas default InputFilter.

## Model

* Fgsl\Model\AbstractModel

This component defines minimal structure for a model and is used by MVC components.

## MVC

* Fgsl\Mvc\Controller\AbstractCrudController

This component makes easy to create CRUD pages with pagination using Laminas\Db.

* Fgsl\Mvc\Controller\AbstractDoctrineCrudController

This component makes easy to create CRUD pages with pagination using Doctrine.

## ServiceManager

*  Fgsl\ServiceManager\ServiceManager

This component is a helper to application DI container.

## View

* Fgsl\View\JSHelper

This component helps to load in a organized way Javascript into view scripts.
