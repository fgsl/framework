<?php
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
namespace Fgsl\Mvc\Controller;

use Fgsl\Db\TableGateway\AbstractTableGateway;
use Laminas\Form\Form;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Paginator\Paginator;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\I18n\Translator as MvcTranslator;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\I18n\Translator\Resources;
use Laminas\I18n\Translator\Translator;
use Laminas\Validator\AbstractValidator;
use Laminas\Db\ResultSet\ResultSet;

abstract class AbstractCrudController extends AbstractActionController
{
    /**
     *
     * @var integer
     */
    protected $itemCountPerPage;

    /**
     *
     * @var string
     */
    protected $modelClass;

    /**
     *
     * @var string
     */
    protected $route;

    /**
     *
     * @var AbstractTableGateway
     */
    protected $table;

    /**
     *
     * @var AbstractTableGateway
     */
    protected $parentTable;

    /**
     *
     * @var string
     */
    protected $tableClass;

    /**
     *
     * @var string
     */
    protected $title;

    public function __construct($table, $parentTable, $sessionManager)
    {
        $this->table = $table;
        $this->parentTable = $parentTable;
        $sessionManager->start();
    }

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $controller = $this->getControllerName();

        $urlEdit = $this->url()->fromRoute($this->route, [
            'controller' => $controller,
            'action' => 'edit'
        ]);
        $urlHomepage = $this->url()->fromRoute('home');
        $urlDelete = $this->url()->fromRoute($this->route, [
            'controller' => $controller,
            'action' => 'delete'
        ]);

        $calledClass = get_called_class();
        $controller = strtolower(end(explode('\\',str_replace('Controller','',$calledClass))));
        return new ViewModel([
            'controller' => $controller,
            'paginator' => $this->getPaginator(),
            'route' => $this->route,
            'urlEdit' => $urlEdit,
            'urlDelete' => $urlDelete,
            'urlHomepage' => $urlHomepage
        ]);
    }

    /**
     *
     * @return \Laminas\Paginator\Paginator
     */
    protected function getPaginator()
    {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($this->table->getModel(null));
        $pageAdapter = new DbSelect($this->table->getSelect(), $this->table->getSql(),$resultSet);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()
            ->fromRoute('page', 1));
        $paginator->setItemCountPerPage($this->itemCountPerPage);
        return $paginator;
    }

    /**
     * Action to add/edit and change records
     */
    public function editAction()
    {
        $key = $this->params()->fromRoute('key', null);
        $model = $this->table->getModel($key);
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
     * @param mixed $key
     * @return string
     */
    abstract function getEditTitle($key);

    /**
     *
     * @param boolean $full
     * @return Form
     */
    abstract function getForm($full = FALSE);

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
            $model->populate($form->getData());
            $model->save();
        }
        return $this->redirect()->toRoute($this->route, [
            'controller' => $this->getControllerName()
        ]);
    }

    /**
     * Action to remove records
     */
    public function deleteAction()
    {
        $key = $this->params()->fromRoute('key', null);
        $this->table->delete($key);
        return $this->redirect()->toRoute($this->route, [
            'controller' => $this->getControllerName()
        ]);
    }

    protected function initValidatorTranslator()
    {
        $translator = new Translator();
        $mvcTranslator = new MvcTranslator($translator);
        $mvcTranslator->addTranslationFilePattern(
            'phparray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        AbstractValidator::setDefaultTranslator($mvcTranslator);
    }

    /**
     *
     * @return object
     */
    protected function getObject($namespace)
    {
        return new $namespace(
            $this->table->getKeyName(),
            $this->table->getTable(),
            $this->table->getSql()->getAdapter()
        );
    }

    /**
     * @return string
     */
    protected function getControllerName()
    {
        $controller = end(explode('\\',str_replace('Controller','',get_called_class())));
        return lcfirst($controller);
    }
}
