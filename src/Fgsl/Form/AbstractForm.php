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
namespace Fgsl\Form;

use Laminas\Form\Element\Select;
use Laminas\Form\Form;
use Laminas\Form\Element\Checkbox;

abstract class AbstractForm extends Form
{
    /**
     * @var string
     */
    const CHECKBOX = 'checkbox';
    
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
     * @var string
     */
    const RADIO = 'radio';
    
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
        } elseif ($type == self::CHECKBOX) {
            $element = new CheckBox($name);
            $element->setLabel($label)
            ->setAttributes($attributes)
            ->setOptions($options);
        } elseif ($type == self::RADIO) {
            $element = new Radio($name);
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
