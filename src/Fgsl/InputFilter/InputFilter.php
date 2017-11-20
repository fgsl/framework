<?php
namespace Fgsl\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\FilterInterface;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter as ZendInputFilter;
use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

class InputFilter extends ZendInputFilter
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
        foreach ($this->inputs as $name) {
            $this->inputs[$name]->setFilterChain($this->filters[$name]);
            $this->inputs[$name]->setValidatorChain($this->validators[$name]);
        }
        return $this;
    }
}