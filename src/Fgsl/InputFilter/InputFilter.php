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
namespace Fgsl\InputFilter;

use Laminas\Filter\FilterChain;
use Laminas\Filter\FilterInterface;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter as LaminasInputFilter;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\ValidatorInterface;

class InputFilter extends LaminasInputFilter
{
    /**
     *
     * @var array
     */
    protected $inputs = array();

    /**
     *
     * @var array
     */
    protected $filters = array();

    /**
     *
     * @var array
     */
    protected $validators = array();

    /**
     *
     * @param string $name
     * @return InputFilter
     */
    public function addInput($name)
    {
        $this->inputs[$name] = new Input($name);
        return $this;
    }

    /**
     *
     * @param string $name
     * @param FilterInterface $filter
     * @return InputFilter
     */
    public function addFilter($name, FilterInterface $filter)
    {
        $this->filters[$name] = isset($this->filters[$name]) ? $this->filters[$name] : new FilterChain();
        $this->filters[$name]->attach($filter);
        return $this;
    }

    /**
     *
     * @param string $name
     * @param ValidatorInterface $validator
     * @return InputFilter
     */
    public function addValidator($name, ValidatorInterface $validator)
    {
        $this->validators[$name] = isset($this->validators[$name]) ? $this->validators[$name] : new ValidatorChain();
        $this->validators[$name]->addValidator($validator);
        return $this;
    }

    /**
     * @return InputFilter
     */
    public function addChains()
    {
        foreach ($this->inputs as $name => $input) {
            $this->inputs[$name]->setFilterChain($this->filters[$name]);
            $this->inputs[$name]->setValidatorChain($this->validators[$name]);
        }
        return $this;
    }
}