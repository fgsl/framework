<?php
namespace Fgsl\Test\Form;

use PHPUnit\Framework\TestCase;
use Laminas\Form\Element\Text;

class FormTest extends TestCase
{
    public function testForm()
    {
        $form = new Form();
        $form->add(['name' => 'nome','type' => 'text']);
        $this->assertTrue($form->get('nome') instanceof Text);
    }
}