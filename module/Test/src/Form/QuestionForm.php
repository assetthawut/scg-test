<?php

namespace Test\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class QuestionForm extends Form
{
    public function __construct()
    {
        parent::__construct('question-form');
        
        $this->setAttribute('method', 'post');


        $this->add(array(

            'name' => 'next',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Next',
                'class' => 'btn btn-primary'
            )

        ));

        $this->add([
            
            'type' => Element\Hidden::class,
            'name' => 'my-hidden',
            'attributes' => [
                'value' => '',
            ],
        ]);


    }
}
