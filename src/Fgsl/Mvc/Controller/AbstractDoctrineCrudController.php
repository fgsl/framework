<?php
namespace Fgsl\Mvc\Controller;

use Zend\Paginator\Paginator;
use Fgsl\Db\DoctrineManager\DoctrineManager;
use Fgsl\Db\Entity\AbstractEntity;
use Fgsl\Form\AbstractForm;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Session\Storage\SessionArrayStorage;

abstract class AbstractDoctrineCrudController extends AbstractCrudController
{
    public function __construct($sessionManager)
    {
        $sessionManager->start();
    }
    
    /**
     *
     * @return \Zend\Paginator\Paginator
     */
    protected function getPaginator()
    {
		$em = DoctrineManager::getEntityManager();
    	$result = $em->getRepository($this->modelClass)->findAll();
		$pageAdapter = new ArrayAdapter($result);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()
            ->fromRoute('page', 1));
        $paginator->setItemCountPerPage($this->itemCountPerPage);
        return $paginator;
    }

    /**
     * (non-PHPdoc)
     * @see \Fgsl\Controller\AbstractCrudController::getModel()
     */
    protected function getModel($key)
    {
        $em = DoctrineManager::getEntityManager();
        if ($key == NULL){
            $model = $this->modelClass;
            return new $model();
        }
        $model = $em->getRepository($this->modelClass)->find($key);
        if ($model == NULL){
            $model = $this->modelClass;
            return new $model();
        }
        return $model;

    }
    
    /**
     * Action to add/edit and change records
     */
    public function editAction()
    {
        $key = $this->params()->fromRoute('key', null);
        $model = $this->getModel($key);
        $form = $this->getForm(TRUE);
        $sessionStorage = new SessionArrayStorage();
        if (isset($sessionStorage->model)) {
            $model->exchangeArray($sessionStorage->model->toArray());
            unset($sessionStorage->model);
            $form->setInputFilter($model->getInputFilter());
        }
        $form->bind($model);
        $this->initValidatorTranslator();
        $form->isValid();
        return [
            'form' => $form,
            'title' => $this->getEditTitle($key)
        ];
    }
    
    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = $this->getForm();
            $model = $this->getObject($this->modelClass);
            $form->setInputFilter($model->getInputFilter());
            $post = $request->getPost();
            $form->setData($post);
            if (! $form->isValid()) {
                $sessionStorage = new SessionArrayStorage();
                $sessionStorage->model = $post;
                return $this->redirect()->toRoute($this->route, [
                    'action' => 'edit',
                    'controller' => $this->getEvent()
                    ->getController()
                ]);
            }
            $this->saveModel($model, $form);
            return $this->redirect()->toRoute($this->route, [
                'controller' => $this->getControllerName()
            ]);
        }
    }    

    /**
     *
     * @param AbstractEntity $model
     * @param AbstractForm $form
     */
    public function saveModel($model, $form)
    {
        $key = $model->getKeyValue();
        // preenche um objeto transiente
        $model->exchangeArray($form->getData());
        $key = $model->getKeyValue();
        // obtém o objeto persistente
        $model = $this->getModel($key);
        $model->exchangeArray($form->getData());
        $em = DoctrineManager::getEntityManager();
		$em->persist($model);
		$em->flush();
    }

    /**
     * Action to remove records
     */
    public function deleteAction()
    {
        $key = $this->params()->fromRoute('key', null);
        $em = DoctrineManager::getEntityManager();
        $em->remove($this->getModel($key));
        $em->flush();
        return $this->redirect()->toRoute($this->route, [
            'controller' => $this->getControllerName()
        ]);
    }

    /**
     *
     * @return \Object
     */
    protected function getObject($namespace)
    {
        return new $namespace();
    }
}