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
namespace Fgsl\Authentication\Adapter;

use Laminas\Authentication\Adapter\AbstractAdapter;
use Laminas\Authentication\Result;
use Doctrine\ORM\EntityManager;

class DoctrineTable extends AbstractAdapter
{
    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var string
     */
    protected $entityName;

    /**
     *
     * @var string
     */
    protected $identityColumn;

    /**
     *
     * @var string
     */
    protected $credentialColumn;

    /**
     *
     * @var boolean
     */
    protected $valid = false;

    /**
     *
     * @var object | NULL
     */
    protected $resultRowObject = null;

    /**
     *
     * @param EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * @param string $entityName
     * @return \Fgsl\Authentication\Adapter\DoctrineTable
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     *
     * @param string $identityColumn
     * @return \Fgsl\Authentication\Adapter\DoctrineTable
     */
    public function setIdentityColumn($identityColumn)
    {
        $this->identityColumn = $identityColumn;
        return $this;
    }

    /**
     *
     * @param string $credentialColumn
     * @return \Fgsl\Authentication\Adapter\DoctrineTable
     */
    public function setCredentialColumn($credentialColumn)
    {
        $this->credentialColumn = $credentialColumn;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Laminas\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $identityColumn = $this->identityColumn;
        $credentialColumn = $this->credentialColumn;
        $dql = "select u from {$this->entityName} u where u.$identityColumn = ?1 and u.$credentialColumn = ?2";
        $query = $this->entityManager->createQuery($dql);
        $query->setParameter(1, $this->identity);
        $query->setParameter(2, $this->credential);
        $result = $query->getResult();
        $code = Result::FAILURE;
        if (! empty($result)) {
            $code = Result::SUCCESS;
            $this->resultRowObject = $result[0];
        }
        return new Result($code, $this->identity);
    }

    /**
     *
     * @return object
     */
    public function getResultRowObject()
    {
        return $this->resultRowObject;
    }
}