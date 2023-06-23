# Fgsl framework

Extensions of Laminas

These components make easy to build web application using Laminas framework.

## Authentication

* `Fgsl\Authentication\Adapter\DoctrineTable`

This class is an database adapter that uses a Doctrine EntityManager to establish the connection.

## Db

* `Fgsl\Db\DoctrineManager\DoctrineManager`
* `Fgsl\Entity\AbstractEntity`

These two components allows to integrante Doctrine as ORM manager of application

* `Fgsl\TableGateway\AbstractTableGateway`
* `Fgsl\TableGateway\AbstractTableModelGateway`

These component is an improvement for Laminas default TableGateway. The first works with ActiveRecord pattern.

## Form

* `Fgsl\Form\AbstractForm`

This component allow to define dynamic forms with less code than Laminas default Form.

## InputFilter

* `Fgsl\InputFilter\InputFilter`

This component improves Laminas default `InputFilter`.

## Model

* `Fgsl\Model\AbstractActiveRecord`

This component defines minimal structure for a model and is used by MVC components. This class implements the Active Record Pattern. It replaces the old class `AbstractModel`.

* `Fgsl\Model\AbstractModel`

This component defines minimal structure for a model and is used by MVC components. It is not coupled to database table record.

> **IMPORTANT**: There is a compatibility break between 3.0.1 and 3.1.0. Classes created with AbstractModel until 3.0.1 must use AbstractActiveRecord from 3.1.0.

## MVC

* `Fgsl\Mvc\Controller\AbstractCrudController`

This component makes easy to create CRUD pages with pagination using Laminas\Db.

* `Fgsl\Mvc\Controller\AbstractDoctrineCrudController`

This component makes easy to create CRUD pages with pagination using Doctrine.

## ServiceManager

* `Fgsl\ServiceManager\ServiceManager`

This component is a helper to application DI container.

## View

* `Fgsl\View\JSHelper`

This component helps to load in a organized way Javascript into view scripts.
