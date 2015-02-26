<?php

namespace Application\Model;

use Zend\Form\Form;

/**
 * Class PasswordPreviewForm
 * @package Application\Model
 */
class PasswordPreviewForm extends Form
{
    /**
     * @inheritdoc
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array('label' => '* Password'),
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Password',
                'title'       => 'Inserisci password',
                'id'          => 'password',
                'maxlength'   => 50,
            )
        ));
    }
}