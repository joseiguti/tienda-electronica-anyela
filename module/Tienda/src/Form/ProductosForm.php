<?php

namespace Tienda\Form;

use Laminas\Form\Form;
use Laminas\Validator\StringLength;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Validator\EmailAddress;

class ProductosForm extends Form
{
    public function __construct($producto = null)
    {
        $this->addInputFilter();
        
        parent::__construct('tienda_form');

        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
            'attributes' => [
                'id' => 'id',
                'value' => (!is_null($producto)?$producto->id:''),
            ],
        ]);

        $this->add([
            'name' => 'nombre',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre',
            ],
            'attributes' => [
                'id' => 'nombre',
                'value' => (!is_null($producto)?$producto->nombre:''),
            ],
            
        ]);

        $this->add([
            'name' => 'precio',
            'type' => 'text',
            'options' => [
                'label' => 'Precio',
            ],
            'attributes' => [
                'id' => 'precio',
                'value' => (!is_null($producto)?$producto->precio:''),
            ],

        ]);

        $this->add([
            'name' => 'cantidad',
            'type' => 'text',
            'options' => [
                'label' => 'Cantidad',
            ],
            'attributes' => [
                'id' => 'cantidad',
                'value' => (!is_null($producto)?$producto->cantidad:''),
            ],

        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => is_null($producto)?'Guardar':'Editar',
                'id'    => 'submitbutton',
            ],
        ]);


    }

    private function addInputFilter (){
        
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'nombre',
            'required' => true,
            'filters' => [
                ['name' => \Laminas\Filter\StripTags::class],
                ['name' => \Laminas\Filter\StringTrim::class],
                ['name' => \Laminas\Filter\StripNewlines::class],
            ],
            'validators' => [
                [
                    'name' => \Laminas\Validator\StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                        'messages' => [
                            \Laminas\Validator\StringLength::TOO_SHORT => "No puede ser menor a 3 caracteres.",
                            \Laminas\Validator\StringLength::TOO_LONG => "No puede ser mayor a 100 caracteres.",
                        ],
                    ],
                ],
                [
                    'name' => \Laminas\Validator\NotEmpty::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'messages' => [
                            \Laminas\Validator\NotEmpty::IS_EMPTY => "No puede ser vacio.",
                        ],
                    ],
                ],
            ],
        ]);

    }
}