<?php
namespace Fgsl\Form;

use Zend\Form\Element\Select;
use Zend\Form\Form;

abstract class AbstractForm extends Form
{
    /**
     *
     * @var string
     */
    const HIDDEN = 'hidden';
    /**
     *
     * @var string
     */
    const NUMBER = 'number';
    /**
     *
     * @var string
     */
    const PASSWORD = 'password';
    /**
     *
     * @var string
     */
    const SELECT = 'select';
    /**
     *
     * @var string
     */
    const SUBMIT = 'submit';

    /**
     *
     * @var string
     */
    const TEXT = 'text';
    /**
     *
     * @param string $name
     * @param string $type
     * @param string $label
     * @param array $attributes
     * @param array $options
     */
    protected function addElement($name, $type, $label = null, $attributes = array(), $options = array())
    {
        if ($type == self::SELECT) {
            $element = new Select($name);
            $element->setLabel($label)
                ->setAttributes($attributes)
                ->setOptions($options);
        } else {
            $attributes['type'] = $type;

            if ($type == self::SUBMIT)
                $attributes['value'] = $label;
            else
                $options['label'] = $label;

            $element = array(
                'name' => $name,
                'attributes' => $attributes,
                'options' => $options
            );
        }

        $this->add($element);
        return $this;
    }
}
