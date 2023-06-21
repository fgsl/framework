<?php
declare(strict_types=1);
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
    protected $inputs = array();

    protected $filters = array();

    protected $validators = array();

    public function addInput(string $name, $required = true): InputFilter
    {
        $input = new Input($name);
        $input->setRequired($required);
        $this->inputs[$name] = $input;
        return $this;
    }

    public function addFilter(string $name, FilterInterface $filter): InputFilter
    {
        $this->filters[$name] = isset($this->filters[$name]) ? $this->filters[$name] : new FilterChain();
        $this->filters[$name]->attach($filter);
        return $this;
    }

    public function addValidator(string $name, ValidatorInterface $validator): InputFilter
    {
        $this->validators[$name] = isset($this->validators[$name]) ? $this->validators[$name] : new ValidatorChain();
        $this->validators[$name]->addValidator($validator);
        return $this;
    }

    public function addChains(): InputFilter
    {
        foreach ($this->inputs as $name => $input) {            
            $this->filters[$name] = isset($this->filters[$name]) ? $this->filters[$name] : new FilterChain();
            $input->setFilterChain($this->filters[$name]);
            $this->validators[$name] = isset($this->validators[$name]) ? $this->validators[$name] : new ValidatorChain();
            $input->setValidatorChain($this->validators[$name]);
            $this->add($input);
        }
        return $this;
    }
}