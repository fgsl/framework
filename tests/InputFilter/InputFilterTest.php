<?php
namespace Fgsl\Test\InputFilter;

use PHPUnit\Framework\TestCase;
use Fgsl\InputFilter\InputFilter;
use Laminas\Filter\Digits;
use Laminas\I18n\Filter\Alpha;

class InputFilterTest extends TestCase
{
    public function testInputFilter()
    {
        $inputFilter = new InputFilter();
        $inputFilter->addInput('code');
        $inputFilter->addInput('name');
        $inputFilter->addFilter('code', new Digits())
        ->addFilter('name', new Alpha());
        $inputFilter->addValidator('code', new \Laminas\Validator\Digits())
        ->addValidator('name', new \Laminas\I18n\Validator\Alpha());
        $inputFilter->addChains();
        $inputFilter->setData([
            'code' => 'something',
            'name' => '1234'
        ]);        
        $this->assertFalse($inputFilter->isValid());
    }
}